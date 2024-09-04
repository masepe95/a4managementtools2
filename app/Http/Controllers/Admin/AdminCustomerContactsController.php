<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminCustomerContactsController extends Controller
{
    private static function getContacts($usr, $selContact): JsonResponse
    {
        // Ritorna i contatti del customer (ritorna un array vuoto se nessun contatto è stato trovato).
        $contacts = DB::select('SELECT `id`, `firstname`, `lastname`, `email`, `additional_name`,' .
                                     ' `job_title`, `phone`, `mobile_phone`, `notes`' .
                                ' FROM `contact` WHERE `customer_id` = :cust ORDER BY `firstname`, `lastname`',
                               [ 'cust' => $usr->customer_id ]);

        // Nome del customer a cui appartengono i contatti.
        $customerName = DB::scalar('SELECT `name` FROM `customer` WHERE `id` = :cust', [ 'cust' => $usr->customer_id ]);

        // Se non c'è una selezione corrente ($selContact = 0), assumi come nuova selezione
        // la prima row della collection $contacts (se esiste).
        if ($selContact <= 0) {
            if (count($contacts) > 0) $selContact = $contacts[0]->id;
        }
        else if (count($contacts) > 0) {
            // Controlla che l' `id` $selContact esista nell'array $contacts, in caso contrario,
            // assumi l' `id` della prima row della collection $contacts (avviene durante il cambio
            // dell'Impersonated employee o a causa di una injection).
            $sel = $contacts[0]->id;
            foreach ($contacts as $cont) {
                if ($cont->id == $selContact) {
                    $sel = $selContact;
                    break;
                }
            }

            $selContact = $sel;
        }

        $additional = __('admin/adm-customer-contacts.additional-name') . ': ';
        $jobTitle = __('admin/adm-customer-contacts.job-title') . ': ';
        $contactOpts = ''; $selected = [];

        foreach ($contacts as $contact) {
            $sel = ($contact->id == $selContact) ? ' selected=""' : '';
            if (strlen($sel) > 0) $selected = [
                'id' => $contact->id,
                'firstname' => $contact->firstname,
                'lastname' => $contact->lastname,
                'email' => $contact->email,
                'additional_name' => $contact->additional_name ?? '',
                'job_title' => $contact->job_title ?? '',
                'phone' => $contact->phone ?? '',
                'mobile_phone' => $contact->mobile_phone ?? '',
                'notes' => $contact->notes ?? ''
            ];

            $fullname = htmlentities($contact->firstname . ' ' . $contact->lastname, ENT_QUOTES, 'UTF-8');
            $email = htmlentities($contact->email, ENT_QUOTES, 'UTF-8');
            $add = $contact->additional_name ?? '';
            if (strlen($add) > 0) $add = $additional . $add;

            $job = $contact->job_title ?? '';
            if (strlen($job) > 0) $job = $jobTitle . $job;

            $sep = (strlen($add) > 0 && strlen($job) > 0) ? ' || ' : '';
            $extra = htmlentities($add . $sep . $job, ENT_QUOTES, 'UTF-8');
            $extra = " data-te-select-secondary-text=\"$extra\"";
            $contactOpts .= "<option value=\"{$contact->id}\"$extra$sel>$fullname &nbsp; &lt;$email&gt;</option>";
        }

        return response()->json([ 'contacts' => $contactOpts, 'selected' => $selected, 'customer-name' => $customerName ]);
    }

    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        $selContact = (int) $request['customer-contact-names'] ?? 0;

        return AdminCustomerContactsController::getContacts($usr, $selContact);
    }

    public function edit(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selContact = (int) $request['customer-contact-names'] ?? 0;

        $validated = $request->validate([
            'contact-firstname' => 'required|max:64',
            'contact-lastname' => 'required|max:64',
            'contact-email' => 'required|email:rfc|max:128',
            'contact-additional-name' => 'nullable|max:64',
            'contact-mobile-phone' => 'nullable|max:32',
            'contact-phone' => 'nullable|max:32',
            'contact-job-title' => 'nullable|max:64',
            'contact-notes' => 'nullable|max:65535',
        ]);

        // Il parametro `customer_id` garantisce che i dati siano modificati solo se $selContact
        // è un impiegato appartenente al `customer_id` stesso.
        DB::update('UPDATE `contact` SET `firstname` = :firstname, `lastname` = :lastname, `email` = :email,' .
                                       ' `additional_name` = :additional, `job_title` = :jobTitle,' .
                                       ' `phone` = :phone, `mobile_phone` = :mobilePhone, `notes` = :notes' .
                    ' WHERE `id` = :id AND `customer_id` = :cust',
                   [ 'firstname' => $validated['contact-firstname'], 'lastname' => $validated['contact-lastname'],
                     'email' => $validated['contact-email'], 'additional' => $validated['contact-additional-name'],
                     'jobTitle' => $validated['contact-job-title'], 'phone' => $validated['contact-phone'],
                     'mobilePhone' => $validated['contact-mobile-phone'], 'notes' => $validated['contact-notes'],
                     'id' => $selContact, 'cust' => $usr->customer_id,
                   ]);

        return AdminCustomerContactsController::getContacts($usr, $selContact);
    }

    public function add(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        $validated = $request->validate([
            'contact-firstname' => 'required|max:64',
            'contact-lastname' => 'required|max:64',
            'contact-email' => 'required|email:rfc|max:128',
            'contact-additional-name' => 'nullable|max:64',
            'contact-mobile-phone' => 'nullable|max:32',
            'contact-phone' => 'nullable|max:32',
            'contact-job-title' => 'nullable|max:64',
            'contact-notes' => 'nullable|max:65535',
        ]);

        DB::insert('INSERT INTO `contact` (`customer_id`, `firstname`, `lastname`, `email`, `additional_name`,' .
                                         ' `job_title`, `phone`, `mobile_phone`, `notes`)' .
                              ' VALUES (:cust, :firstname, :lastname, :email, :additional, :jobTitle,' .
                                      ' :phone, :mobilePhone, :notes)',
                   [ 'cust' => $usr->customer_id, 'firstname' => $validated['contact-firstname'],
                     'lastname' => $validated['contact-lastname'], 'email' => $validated['contact-email'],
                     'additional' => $validated['contact-additional-name'], 'jobTitle' => $validated['contact-job-title'],
                     'phone' => $validated['contact-phone'], 'mobilePhone' => $validated['contact-mobile-phone'],
                     'notes' => $validated['contact-notes'],
                   ]);

        // Ottiene l'id auto_increment appena inserito.
        $newId = (int) DB::getPdo()->lastInsertId();

        return AdminCustomerContactsController::getContacts($usr, $newId);
    }

    public function delete(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selContact = (int) $request['customer-contact-names'] ?? 0;

        // Nota: l'utilizzo del campo `customer_id` nella clausola WHERE evita che si possa
        //       iniettare un `id` di un contatto non appartenente al customer stesso.
        DB::delete('DELETE FROM `contact` WHERE `id` = :id AND `customer_id` = :cust',
                   [ 'id' => $selContact, 'cust' => $usr->customer_id ]);

        return AdminCustomerContactsController::getContacts($usr, 0);
    }
}
