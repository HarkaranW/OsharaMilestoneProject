<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Your Oshara Reward</title>
</head>
<body style="background:#f8fafc; font-family: Arial, sans-serif; padding:40px;">

  <div style="max-width:520px; margin:0 auto; background:white; padding:32px; border-radius:16px; border:1px solid #e2e8f0;">

    <h2 style="margin-top:0;">🎉 You unlocked a reward!</h2>

    <p style="font-size:15px; color:#334155;">
      Hi {{ $access->client_name ?? $access->client_email }},
    </p>

    <p style="font-size:15px; color:#334155;">
      Congratulations on reaching <strong>{{ $access->milestone->name }}</strong>.
      We’ve prepared a gift for you.
    </p>

    <div style="text-align:center; margin:30px 0;">
      <a href="{{ $link }}"
         style="background:#0f172a; color:white; text-decoration:none; padding:14px 22px; border-radius:10px; font-weight:bold;">
        Discover Your Reward
      </a>
    </div>

    <p style="font-size:14px; color:#64748b;">
      This secure link can only be used once and may expire.
    </p>

    <p style="font-size:13px; color:#94a3b8;">
      If the button doesn’t work, copy this link into your browser:<br>
      {{ $link }}
    </p>

    <p style="font-size:14px; color:#334155; margin-top:20px;">
      — Oshara Team
    </p>

  </div>
</body>
</html>
