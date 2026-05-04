<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Parental Control Link Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #222;">
    <h2>Parental Control Link Request</h2>
    <p>Hello,</p>
    <p>
        <strong>{{ $parentName }}</strong> is requesting to link your patient account
        as their child account on Dentaease
        @if($relationship)
            (relationship: <strong>{{ $relationship }}</strong>)
        @endif.
    </p>
    <p>
        If you approve, the parent will be able to view your appointments and switch
        into your account on your behalf. You can unlink at any time from your settings.
    </p>
    <p style="margin: 24px 0;">
        <a href="{{ $confirmUrl }}"
           style="background:#2563eb;color:#fff;padding:10px 16px;border-radius:4px;text-decoration:none;">
            Confirm link request
        </a>
    </p>
    <p style="font-size: 12px; color: #666;">
        Or copy this link into your browser:<br>
        {{ $confirmUrl }}
    </p>
    <p style="font-size: 12px; color: #666;">
        This link will expire in 48 hours. If you didn't expect this request, you can
        ignore this email and no link will be created.
    </p>
</body>
</html>
