<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Support Reply</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1f2937;">
    <h2>Oshara Support</h2>

    <p>Hello {{ $messageModel->name }},</p>

    <p>Thank you for contacting us. Here is our reply to your message regarding:</p>

    <p><strong>{{ $messageModel->subject }}</strong></p>

    <div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 8px; background: #f9fafb;">
        {!! nl2br(e($replyText)) !!}
    </div>

    <p style="margin-top: 20px;">Best regards,<br>Oshara Support</p>
</body>
</html>