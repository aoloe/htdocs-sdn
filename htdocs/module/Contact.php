<?php
//
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// use function Aoloe\debug as debug;

// use function Aoloe\debug as debug;
// Aoloe\debug('test', 'test');

class Contact extends Aoloe\Module_abstract {
    public function get_content() {
        $result = "";
        // Aoloe\debug('_REQUEST', $_REQUEST);
        $page_url = null;

        $contact_form = new Aoloe\Contact_form();
        $field_post = array();
        $contact_form->set_request_prefix('');
        $contact_form->clear_field_request();

        $contact_form->add_field_request('adherer', 'Non');
        $contact_form->add_field_request('aider', 'Non');
        $contact_form->add_field_request('participer_stand', 'Non');
        $contact_form->add_field_request('inscrire_liste_de_courriers_informations', 'Non');
        $contact_form->add_field_request('comite', 'Non');


        $contact_form->add_field_request('email');
        $contact_form->add_field_request('titre');
        $contact_form->add_field_request('prenom');
        $contact_form->add_field_request('nom');
        $contact_form->add_field_request('adresse');
        $contact_form->add_field_request('cp');
        $contact_form->add_field_request('ville');
        $contact_form->add_field_request('pays');
        $contact_form->add_field_request('email');
        $contact_form->add_field_request('tel');
        $contact_form->add_field_request('comments');
        $contact_form->add_field_request('tel');

        $contact_form->set_force_smtp();
        $contact_form->set_mail_from('info@sortirdunucleaire.ch');
        $contact_form->set_mail_to('info@sortirdunucleaire.ch');
        $contact_form->set_subject_prefix('[SDN] ');
        $contact_form->set_subject('Formulaire de contact');
        if ($contact_form->is_submitted()) {
            $contact_form->read();
            // Aoloe\debug('contact_form', $contact_form);
            if (!$contact_form->is_valid()) {
                // Aoloe\debug('_REQUEST', $_REQUEST);
            } else {
                $sent = true;
                if (!$contact_form->is_spam()) { // if is spam do not send put show the sent page
                    $sent = $contact_form->send();
                    // Aoloe\debug('sent', $sent);
                }
                // Aoloe\debug('sent', $sent);
                if ($sent) {
                    // TODO: correctly show the sent page
                    $page_url = 'association_contact_sent';
                } else {
                    // TODO: prepare the fields passed to the form in order to show an error message
                }
            }
        }

        // Aoloe\debug('page_url', $page_url);
        include_once('module/Page.php');
        $page_module = new Page();
        $page_module->set_page_url(isset($page_url) ? $page_url : $this->page_url);
        $page_module->set_site($this->site);
        // $page_module->set_page_content($page_content);
        $result = $page_module->get_content();
        return $result;
    }
}
