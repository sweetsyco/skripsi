<!DOCTYPE html>
<html>
<head>
    <title>Test Button</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <button class="btn-accept action-btn btn btn-success btn-sm" data-id="999">Test Terima</button>
    
    <script>
    $(document).on('click', '.btn-accept', function() {
        console.log('Tombol test diklik! ID:', $(this).data('id'));
        alert('Tombol berfungsi!');
    });
    </script>
</body>
</html>