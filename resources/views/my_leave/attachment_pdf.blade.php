<html>
<head>
<title>Attached Medical Document - PDF File</title>
</head>
<body>

<object data="/uploads/attach_folder/{{$file_name}}" type="application/pdf" width="100%" height="100%">
    <embed src="/uploads/attach_folder/{{$file_name}}" type="application/pdf">
        <p>This browser does not support PDFs. Please click here to view it: <a href="/uploads/attach_folder/{{$file_name}}">View PDF</a>.</p>
    </embed>
</object>

</body>
</html>