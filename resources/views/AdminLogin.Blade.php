<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slide Navbar</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="slide navbar style.css">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="form-container">
            <!-- Error handling -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="text-white">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="get" action="/check">
                <label for="chk" class="toggle-label">Login</label>
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f1f1f1;
    font-family: 'Jost', sans-serif;
    margin: 0;
}

.container {
    position: relative;
    width: 100%;
    max-width: 400px;
    height: 600px;
    background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/cover;
    border-radius: 12px;
    box-shadow: 5px 20px 50px rgba(0, 0, 0, 0.3);
    padding: 30px;
    overflow: hidden;
}

#chk {
    display: none;
}

.form-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 360px;
    text-align: center;
}

.toggle-label {
    font-size: 24px;
    color: #573b8a;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.toggle-label:hover {
    color: #6d44b8;
}

input {
    width: 100%;
    padding: 15px;
    margin: 15px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: #573b8a;
}

button {
    width: 100%;
    padding: 15px;
    margin: 10px 0;
    border: none;
    background-color: #573b8a;
    color: white;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #6d44b8;
}

/* Adjustments for responsive design */
@media (max-width: 500px) {
    .container {
        width: 100%;
        padding: 20px;
    }

    .form-container {
        padding: 20px;
    }

    .toggle-label {
        font-size: 20px;
    }

    input,
    button {
        font-size: 14px;
    }
}
</style>
