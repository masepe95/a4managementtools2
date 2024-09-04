<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Tutti i gate sono implementati con il metodo before().
        Gate::before(function (User $user, string $ability, $kl) {
            if ($user->role == 'siteAdmin') return true;

            // Il formato della stringa $ability è costituito da uno o due nomi,
            // nel secondo caso i due nomi devono essere separati da un punto ('.').
            $names = explode('.', $ability, 2);
            if (count($names) < 2) {
                // Determina se la junction table `res_employee_res_access` ha un'entry che collega
                // l'impiegato correntemente loggato con il nome della resource in `resource_access`.
                $results = DB::select('SELECT `employee_id` FROM `res_employee_res_access`' .
                                       ' WHERE `employee_id` = :emp AND `resource_access_name` = :res',
                                      ['emp' => $user->id, 'res' => $names[0]]);

                // Il risultato ritornato in $results contiene zero o un record.
                if (count($results) > 0) return true;
            }
            else {
                $results = DB::select('SELECT ea.`employee_id` FROM `res_employee_res_access` ea' .
                                        ' JOIN `res_employee_res_permission` ep ON ep.`employee_id` = ea.`employee_id` AND' .
                                                                                 ' ep.`resource_access_name` = ea.`resource_access_name`' .
                                        ' JOIN `resource_permission` rp ON rp.`resource_name` = ep.`resource_access_name` AND' .
                                                                         ' rp.`name` = ep.`resource_permission_name`' .
                                        ' WHERE ea.`employee_id` = :emp AND ea.`resource_access_name` = :acc AND' .
                                                                          ' ep.`resource_permission_name` = :perm',
                                      ['emp' => $user->id, 'acc' => $names[0], 'perm' => $names[1]]);

                // Il risultato ritornato in $results contiene zero o un record.
                if (count($results) > 0) return true;
            }
        });
    }
}
