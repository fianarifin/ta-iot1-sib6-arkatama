<?php
namespace App\Service;

use App\Models\SentMessage;
use App\Models\User;
use Illuminate\Support\Facades\Http;


class WhatsappNotificationService
{
    public static function getConfig()
    {
        return config('wasender');
    }

    public static function getToken()
    {
        return self::getConfig()['token'];
    }

    public static function getEndpoint()
    {
        return self::getConfig()['endpoint'];
    }

    public static function sendMessage($target, $message)
    {
        $endPoint = self::getEndpoint() . '/send';

        $headers = [
            'Authorization' => self::getToken()
        ];

        $options = [
            [
                'name' => 'target',
                'contents' => $target
            ],
            [
                'name' => 'message',
                'contents' => self::formatMessage($message)
            ]
        ];

        $response = Http::withHeaders($headers)
            ->asMultipart()
            ->post($endPoint, $options);

        return $response->body();
    }

    public static function formatMessage($message)
    {
        $message .= PHP_EOL;
        $message .= PHP_EOL;
        $message .= 'Dikirimkan' . ' oleh IoT Manage Arifin';
        return $message;
    }
    // Existing methods...

    public static function notifikasiHujanLebat($user, $nilaiSensor)
    {
        $target = $user->phone_number;
        $name = $user->name;

        $message = "Peringatan!" . PHP_EOL;
        $message .= "Halo $name, terdeteksi hujan lebat pada sensor Anda. Nilai sensor: $nilaiSensor. Harap waspada terhadap kemungkinan banjir.";

        return self::sendMessage($target, $message);
    }

    public static function notifikasiHujanLebatMassal($nilaiSensor)
    {
        $nilaiMaksimalSensor = 700; // threshold for heavy rain
        $durasiPesan = 3; // duration in minutes

        // Fetch users with phone numbers
        $users = User::whereNotNull('phone_number')->get();

        // Check when the last notification was sent
        $lastSent = SentMessage::where('type', 'rain')
            ->orderBy('created_at', 'desc')
            ->first();

        // If the sensor value exceeds the threshold
        if ($nilaiSensor <= $nilaiMaksimalSensor) {
            return;
        }

        // If no notification has been sent before or the duration has passed
        if (!$lastSent || abs(now()->diffInMinutes($lastSent->created_at)) >= $durasiPesan) {
            foreach ($users as $user) {
                self::notifikasiHujanLebat($user, $nilaiSensor);
            }

            // Save to database
            SentMessage::create([
                'type' => 'rain',
            ]);
        }
    }
}


