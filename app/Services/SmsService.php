<?php

namespace App\Services;

use App\Models\SmsLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SmsService
{
    /**
     * መልዕክት መላኪያ ዋና ሜተድ (Send SMS)
     */
    public static function send($phoneNumber, $message, $type = 'general_notice', $studentId = null)
    {
        // ስልክ ቁጥሩን ወደ ኢትዮጵያ ስታንዳርድ (+251...) መቀየር
        $formattedPhone = self::formatEthiopianPhoneNumber($phoneNumber);

        if (!$formattedPhone) {
            return false;
        }

        $status = 'sent';
        $responseId = 'SMS-' . uniqid();

        /* 
           ማስታወሻ፦ ከኢትዮጵያ SMS Gateway (ለምሳሌ፡ AfroMessage ወይም Ethio Telecom API) ጋር ማገናኛ፡
           $response = Http::withHeaders(['Authorization' => 'Bearer YOUR_API_KEY'])
               ->post('https://api.afromessage.com/api/send', [
                   'to' => $formattedPhone,
                   'message' => $message,
               ]);
        */

        // የተላከውን መልዕክት በዳታቤዝ ውስጥ መዝግቦ መያዝ
        SmsLog::create([
            'phone_number' => $formattedPhone,
            'student_id' => $studentId,
            'message' => $message,
            'type' => $type,
            'status' => $status,
            'response_id' => $responseId,
            'sent_by' => Auth::id(),
        ]);

        return true;
    }

    /**
     * የተማሪ የቀሪነት ማሳወቂያ ለወላጅ በ SMS መላኪያ
     */
    public static function sendAttendanceAlert($student, $date, $status)
    {
        $parentPhone = optional($student->parent)->father_phone ?? optional($student->address)->phone_number;

        if ($parentPhone) {
            $statusText = $status === 'absent' ? 'ቀሪ ሆኗል/ሆናለች' : 'ዘግይቷል/ዘግይታለች';
            $message = "ውድ ወላጅ፡ ተማሪ {$student->full_name} በዛሬው ዕለት ({$date}) በትምህርት ገበታው ላይ {$statusText}። SmartSchool Ethiopia";
            return self::send($parentPhone, $message, 'attendance', $student->id);
        }

        return false;
    }

    /**
     * የትምህርት ክፍያ ማስታወሻ ለወላጅ በ SMS መላኪያ
     */
    public static function sendFeeReminder($student, $amount, $month)
    {
        $parentPhone = optional($student->parent)->father_phone ?? optional($student->address)->phone_number;

        if ($parentPhone) {
            $message = "ውድ ወላጅ፡ የተማሪ {$student->full_name} የ{$month} ወር የትምህርት ክፍያ ያልተጠናቀቀ መሆኑን በትህትና እናስታውሳለን። SmartSchool Ethiopia";
            return self::send($parentPhone, $message, 'fee_reminder', $student->id);
        }

        return false;
    }

    /**
     * የስልክ ቁጥር ፎርማት ማስተካከያ (09... ወደ +2519...)
     */
    private static function formatEthiopianPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) == 10 && substr($phone, 0, 2) == '09') {
            return '+251' . substr($phone, 1);
        } elseif (strlen($phone) == 9 && substr($phone, 0, 1) == '9') {
            return '+251' . $phone;
        } elseif (strlen($phone) == 12 && substr($phone, 0, 3) == '251') {
            return '+' . $phone;
        }

        return null;
    }
}
