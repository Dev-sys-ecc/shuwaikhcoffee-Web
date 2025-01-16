<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
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
            color: green;
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
    <h1>Payment Successful</h1>
    <p>Thank you for your payment. Your transaction was successful.</p>

    <table>
        <tr>
            <th colspan="2" class="heading">Transaction Details</th>
        </tr>
        <tr>
            <td>Payment ID:</td>
            <td>{{ $responseData['paymentid'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Post Date:</td>
            <td>{{ $responseData['postdate'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Result Code:</td>
            <td>{{ $responseData['result'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Transaction ID:</td>
            <td>{{ $responseData['tranid'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Auth:</td>
            <td>{{ $responseData['auth'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Track ID:</td>
            <td>{{ $responseData['trackid'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Ref No:</td>
            <td>{{ $responseData['ref'] ?? '' }}</td>
        </tr>
        <tr>
            <td>Amount:</td>
            <td>{{ $responseData['amt'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF1:</td>
            <td>{{ $responseData['udf1'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF2:</td>
            <td>{{ $responseData['udf2'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF3:</td>
            <td>{{ $responseData['udf3'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF4:</td>
            <td>{{ $responseData['udf4'] ?? '' }}</td>
        </tr>
        <tr>
            <td>UDF5:</td>
            <td>{{ $responseData['udf5'] ?? '' }}</td>
        </tr>
    </table>
</div>

</body>
</html>
