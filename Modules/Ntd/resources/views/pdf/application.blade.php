<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
    </style>
</head>
<body>

<h2>Hồ sơ học sinh</h2>

<p>Mã hồ sơ: {{ $application->code }}</p>
<p>Họ tên: {{ $application->student?->full_name }}</p>
<p>Ngày sinh: {{ $application->student?->date_of_birth }}</p>

</body>
</html>