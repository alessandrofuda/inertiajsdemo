<?php

namespace App\Http\Controllers;

use App\Domain\AddOrganizationsViaMailAttachment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class InboundEmailController extends Controller
{
    public function parseEmail(Request $request) {

        $attachments = $request->get('attachments') ? json_decode($request->get('attachments')) : null;

        if ($attachments) {
            foreach ($attachments as $attachment) {
                $content_type = 'content-type'; // illegal dash in object
                if ($attachment->$content_type === 'text/csv') {
                    try {
                        $client = new Client();
                        $response = $client->get($attachment->url, [
                            'auth' => ['api', config('services.mailgun.secret')],
                        ]);
                        $attachment_body = $response->getBody();
                        $handle_attachment = new AddOrganizationsViaMailAttachment($attachment_body);
                        $handle_attachment->insertCsvInDb();

                    } catch (GuzzleException $e) {
                        Log::error('Exception_: '. $e->getMessage());
                    }
                }
            }
        }
        // https://laravel-news.com/laravel-inbound-email
        return response()->json(['status'=>'ok'], 200);
    }
}
