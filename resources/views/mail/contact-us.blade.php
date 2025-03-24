<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us | IKON Mart</title>
</head>

<body>

    <h4> Dears: IKON Mart Team </h4>

    <p style="white-space: pre-line">
        {{ $contact->message }}
    </p>

    <div style="text-align: right">
        <ul style="list-style: none">
            <li>
                Name: {{ $contact->name }}
            </li>
            <li>
                Phone: {{ $contact->phone }}
            </li>
            <li>
                Email: {{ $contact->email }}
            </li>
            <li>
                Date: {{ $contact->created_at->format('d-M-Y') }}
            </li>
        </ul>
    </div>

</body>

</html>
