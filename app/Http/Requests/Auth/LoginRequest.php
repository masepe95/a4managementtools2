<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');
        $credentials['employee_status'] = 'enabled';  // Il campo `employee_status` deve essere 'enabled'.

        // Nota: se necessario, è disponibile il metodo Auth::attemptWhen() che dispone
        //       di un parametro addizionale rispetto a Auth::attempt().
        //       Vedi "https://laravel.com/docs/11.x/authentication#specifying-additional-conditions".
        //       Infatti, Auth::attemptWhen() può essere invocata passando una closure (una funzione
        //       anonima) che viene invocata solo se le credenziali del primo parametro sono corrette.
        //       In tal caso, viene invocata la closure che esegue ulteriori controlli, se la
        //       closure ritorna false, l'autenticazione fallisce.
        //       Eventualmente, la closure può modificare il messaggio di errore:
        //         $errType = 'auth.failed';
        //         $cb = function (User $user) use(&$errType) {
        //             // Se viene rilevato un errore, modificare la stringa di errore
        //             // in $errType, questa è stata passata per reference (vedi &).
        //             . . . .
        //         };
        if (!Auth::attemptWhen($credentials,
            // Nota: il metodo boolean() ritorna true se il valore della key (passata come parametro)
            //       è 1, "1", "true", "on" o "yes", altrimenti ritorna false.
            function (User $user) {
                // Oltre allo status della colonna `employee_status` della tabella `employee`, anche
                // la colonna `customer_status` della tabella `customer` deve avere il valore 'enabled'.
                // Nota: un valore diverso da 'enabled' di `customer_status` disabilita tutti i suoi employees.
                return Customer::find($user->customer_id)->customer_status == 'enabled';
            }, $this->boolean('remember'))) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user = auth()->user();

        // Ottieni la lingua predefinita dell'utente appena loggato.
        $locale = $user->language_code;

        // Inizializza l'utente impersonato con lo stesso id dell'utente appena loggato.
        // Solo un Super User (employee role: 'siteAdmin') avrà accesso al comboBox per la selezione
        // di un diverso utente da impersonare, altrimenti, la variabile di sessione non potrà mai
        // essere modificata.
        session(['impersonated-employee' => $user->id]);

        // Questo metodo (authenticate()) è stato invocato dal metodo store() della classe
        // AuthenticatedSessionController, al ritorno, il metodo store() imposta il cookie
        // 'current-locale' utilizzando redirect()->withCookie() e il valore di App::getLocale()
        // che ritorna il "locale" impostato dal seguente App::setLocale().
        App::setLocale($locale);

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
