<!DOCTYPE html>
<html>
  <body style="font-family: Arial, sans-serif; background:#f6f7fb; padding:24px;">
    <div style="max-width:640px;margin:0 auto;background:#fff;border:1px solid #e7e9f0;border-radius:14px;overflow:hidden;">
      <div style="padding:16px 18px;border-bottom:1px solid #e7e9f0;">
        <div style="font-weight:800;">Oshara</div>
        <div style="color:#64748b;font-size:12px;font-weight:600;">Client Milestones Rewards</div>
      </div>

      <div style="padding:22px 18px;">
        <h2 style="margin:0 0 10px 0;">🎉 Congratulations {{ $access->client_name ?? 'there' }}!</h2>

        <p style="margin:0;color:#475569;line-height:1.6;">
          You’ve reached an important milestone with Oshara.
          Click the button below to discover your reward.
        </p>

        <div style="margin-top:18px;">
          <a href="{{ $link }}"
             style="display:inline-block;background:#2563eb;color:#fff;text-decoration:none;
                    padding:12px 16px;border-radius:12px;font-weight:800;">
            Discover Your Reward
          </a>
        </div>

        <p style="margin-top:18px;color:#64748b;font-size:12px;line-height:1.6;">
          If the button doesn’t work, copy and paste this link:
          <br>
          <span style="font-family: monospace;">{{ $link }}</span>
        </p>
      </div>

      <div style="padding:14px 18px;border-top:1px solid #e7e9f0;text-align:center;color:#64748b;font-size:12px;">
        © {{ date('Y') }} Oshara — This link is private and one-time use.
      </div>
    </div>
  </body>
</html>