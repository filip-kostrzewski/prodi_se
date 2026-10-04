<?php

namespace Tests\Feature\Mail;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use Tests\TestCase;

class ContactInquiryReceivedTest extends TestCase
{
    public function test_mail_escapes_the_name_and_message(): void
    {
        $inquiry = ContactInquiry::factory()->make([
            'name' => '<script>alert(1)</script>',
            'message' => '<script>alert(2)</script>',
        ]);

        $html = (new ContactInquiryReceived($inquiry))->render();

        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
        $this->assertStringNotContainsString('<script>alert(2)</script>', $html);
    }
}
