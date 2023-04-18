<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Requests\ContactRequest;
use App\Mail\AdminContactMail;
use App\Mail\CustomerContactMail;
use App\Models\Contact;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends BaseController
{
    //

    public function getContactPage(Request $request)
    {
        $key = 'contact_page';
        $page = StaticPage::firstOrCreate(['key' => $key]);
        return view('frontend.pages.contact', compact('page'));
    }
    public function postContact(ContactRequest $request)
    {
        $data = $request->only([
            'name', 'email', 'message', 'phone',
        ]);
        $subject = $request->input('subject', 'New Contact');
        $data['subject'] = $subject;

        try {
            //insert contact to database
            Contact::create($data);
            //send mail
            $this->sendMail($data);

            return response()->json([
                'status' => 'success',
                'message' => __('frontend.contact_success_message')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => env("APP_DEBUG")
                    ? $exception->getMessage()
                    : trans('label.something_went_wrong')
            ]);
        }

    }

    public function refreshCaptcha()
    {
        if (request()->wantsJson() || request()->ajax()) {
            return captcha_img('flat');
        }
        return false;
    }

    private function sendMail(array $data)
    {
        $adminEmails = cachedOption('emails_receive_notification');
        $arrayEmails = explode(',', $adminEmails);
        if (!empty($arrayEmails)) {
            foreach ($arrayEmails as $adminEmail) {
                if (isValidEmail($adminEmail)) {
                    Mail::to($adminEmail)->send(new AdminContactMail($data));
                }
            }
        }

        if (option('send_customer_email')) {
            $customerEmail = $data['email'];
            $data['subject'] = __('frontend.contact_success_message');
            $data['message'] = either(
                cachedOption('contact_email_reply_message_' . app()->getLocale()),
                __('frontend.contact_success_message')
            );
            if (isValidEmail($customerEmail)) {
                Mail::to($customerEmail)->send(new CustomerContactMail($data));
            }
        }
    }
}
