<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner"></div>
        <h3>Loading...</h3>
        <p>Mohon tunggu sebentar.</p>
        
        <form id="autoSubmitForm" action="{{ $url }}" method="POST" style="display: none;">
            @csrf
            @foreach($data as $key => $value)
                @if(is_array($value))
                    @foreach($value as $subKey => $subValue)
                        <input type="hidden" name="{{ $key }}[{{ $subKey }}]" value="{{ $subValue }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
        </form>
    </div>

    <script>
        // Auto-submit the form after a short delay
        setTimeout(function() {
            document.getElementById('autoSubmitForm').submit();
        }, 1000);
    </script>
</body>
</html>
