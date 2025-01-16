<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 70%;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .heading {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Payment Failed</h1>
    <p>We're sorry, but there was an error processing your payment. Please try again later.</p>

    <table>
        <tr>
            <th colspan="2" class="heading">Transaction Details</th>
        </tr>
        @if(isset($errorData['Error']) || isset($errorData['ErrorText']))
            <tr>
                <td>Error:</td>
                <td>{{ $errorData['Error'] ?? '' }} - {{ $errorData['ErrorText'] ?? '' }}</td>
            </tr>
        @endif
        <tr>
            <td>Payment ID:</td>
            <td>{{ $errorData['paymentid'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Post Date:</td>
            <td>{{ $errorData['postdate'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Result Code:</td>
            <td>{{ $errorData['result'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Transaction ID:</td>
            <td>{{ $errorData['tranid'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Auth:</td>
            <td>{{ $errorData['auth'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Track ID:</td>
            <td>{{ $errorData['trackid'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Ref No:</td>
            <td>{{ $errorData['ref'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Amount:</td>
            <td>{{ $errorData['amt'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF1:</td>
            <td>{{ $errorData['udf1'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF2:</td>
            <td>{{ $errorData['udf2'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF3:</td>
            <td>{{ $errorData['udf3'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF4:</td>
            <td>{{ $errorData['udf4'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF5:</td>
            <td>{{ $errorData['udf5'] ?? '' }}</td>
        </tr>
    </table>
</div>

</body>
</html>
