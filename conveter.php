<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Live exchange rates — Demo</title>

  <!-- Google font (optional, but matches the feel) -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#f6f8fb;
      --navy:#04112a;
      --card:#ffffff;
      --muted:#7b8896;
      --accent:#0a58ff;
      --pill-green:#e9f8ef;
      --green:#1f9d58;
      --light:#eef4fb;
      --row:#f7f9fb;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: 'Nunito', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,#ffffff 0%, var(--bg) 100%);
      color:#0f1724;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* Top converter card */
    .converter{
      max-width:980px;
      margin:34px auto 8px;
      background:var(--card);
      padding:20px;
      border-radius:10px;
      box-shadow:0 8px 30px rgba(7,17,39,0.06);
      display:flex;
      gap:12px;
      align-items:center;
    }
    .field{
      flex:1;
      display:flex;
      gap:10px;
      align-items:center;
    }
    .amount-box{
      min-width:160px;
      border-radius:8px;
      border:1px solid #e5ecf8;
      padding:16px;
      font-size:18px;
      font-weight:700;
    }
    .select{
      flex:1;
      display:flex;
      gap:8px;
      align-items:center;
      border-radius:8px;
      border:1px solid #e5ecf8;
      padding:10px 12px;
      background:#fff;
    }
    .swap{
      width:44px;
      height:44px;
      border-radius:50%;
      display:flex;
      align-items:center;
      justify-content:center;
      border:1px solid #e8eefb;
      background:linear-gradient(180deg,#fff,#f8fbff);
      cursor:pointer;
      box-shadow:0 2px 6px rgba(17,24,39,0.04);
    }
    .btn{
      background:var(--accent);
      color:white;
      border:none;
      padding:12px 22px;
      font-weight:700;
      border-radius:8px;
      cursor:pointer;
      box-shadow:0 6px 18px rgba(10,88,255,0.16);
    }

    /* Title */
    .title{
      max-width:980px;
      margin:28px auto 12px;
      padding:0 6px;
    }
    .title h1{
      font-size:34px;
      margin:0;
      font-weight:800;
      letter-spacing:-0.02em;
    }
    .title p{
      color:var(--muted);
      margin:8px 0 0;
    }

    /* Table / list */
    .rates{
      max-width:980px;
      margin:20px auto 80px;
      padding:18px;
      background:transparent;
      border-radius:10px;
    }
    .controls{
      display:flex;
      justify-content:flex-end;
      margin-bottom:12px;
      gap:12px;
      align-items:center;
    }
    .toggle{
      display:inline-flex;
      gap:8px;
      align-items:center;
      color:var(--muted);
      font-weight:600;
    }
    .toggle input{display:none}
    .toggle .switch{
      width:42px;height:24px;background:#e9eef7;border-radius:12px;position:relative;
    }
    .toggle .dot{width:20px;height:20px;border-radius:50%;background:white;position:absolute;left:2px;top:2px;transition:all .18s;box-shadow:0 2px 6px rgba(8,22,40,0.06)}
    .toggle input:checked + .switch{background:#001f5d}
    .toggle input:checked + .switch .dot{left:20px;background:#fff}

    .rates-list{
      background:linear-gradient(180deg, #ffffff, #ffffff);
      border-radius:10px;
      overflow:hidden;
      border:1px solid rgba(10,24,48,0.04);
      box-shadow:0 10px 30px rgba(12,24,64,0.04);
    }

    .row{
      display:grid;
      grid-template-columns: 1fr 120px 110px 130px 86px;
      gap:16px;
      align-items:center;
      padding:16px 18px;
      border-bottom:1px solid #f1f6fb;
    }
    .row.header{
      background:transparent;
      font-weight:700;
      color:var(--muted);
      font-size:14px;
    }
    .row .currency{
      display:flex;
      gap:12px;
      align-items:center;
      font-weight:700;
      color:#fff;
      padding:12px;
      border-radius:8px;
    }
    .row.usd .currency{
      background:linear-gradient(90deg,#06132a,#061834);
      box-shadow: inset 0 -6px 24px rgba(3,10,22,0.4);
      color:#fff;
    }
    .flag{
      width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;
      background:linear-gradient(180deg,#feffff,#f1f7ff);
      box-shadow:0 6px 16px rgba(6,12,28,0.06);
      color:#08203d;
    }

    .amt{
      font-weight:700;
      color:#0d1a2b;
    }
    .change{
      display:inline-block;
      background:var(--pill-green);
      color:var(--green);
      padding:8px 10px;
      border-radius:8px;
      font-weight:700;
      text-align:center;
      min-width:86px;
    }
    .spark{
      display:flex;
      align-items:center;
      gap:6px;
    }
    .send{
      background:#0b67ff;
      color:#fff;
      padding:10px 12px;
      border-radius:8px;
      border:none;
      cursor:pointer;
      font-weight:700;
      box-shadow:0 8px 18px rgba(11,103,255,0.12);
    }

    /* small screens */
    @media (max-width:880px){
      .row{grid-template-columns:1fr 96px 96px 96px 72px;font-size:14px;padding:12px}
      .converter{flex-direction:column;align-items:stretch}
      .controls{justify-content:flex-start}
    }
      .back-btn {
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-btn:hover {
            background-color: var(--primary-dark);
        }
  </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Currency Converter</h1>
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </header>

    <!-- Converter Section -->

  <div class="converter" role="region" aria-label="Currency converter">
    <div class="field">
      <div class="amount-box" contenteditable="true" id="amount" aria-label="Amount" role="textbox" spellcheck="false">$1.00</div>
    </div>

    <div class="field">
      <div class="select" id="fromSelect" data-currency="USD" tabindex="0" title="From currency">
        <div style="font-size:18px; margin-right:6px">🇺🇸</div>
        <div>
          <div style="font-weight:700">USD</div>
          <div style="font-size:12px;color:var(--muted)">US Dollar</div>
        </div>
      </div>
      <div class="swap" id="swapBtn" title="Swap currencies">⇄</div>
      <div class="select" id="toSelect" data-currency="EUR" tabindex="0" title="To currency">
        <div style="font-size:18px; margin-right:6px">🇪🇺</div>
        <div>
          <div style="font-weight:700">EUR</div>
          <div style="font-size:12px;color:var(--muted)">Euro</div>
        </div>
      </div>
    </div>

    <div>
      <button class="btn" id="convertBtn">Convert</button>
    </div>
  </div>

  <div class="title">
    <h1>Live exchange rates</h1>
    <p>Compare 100+ currencies in real time &amp; find the right moment to transfer funds</p>
  </div>

  <div class="rates">
    <div class="controls">
      <label class="toggle" title="Inverse display">
        Inverse
        <input type="checkbox" id="inverseToggle" />
        <span class="switch" aria-hidden="true"><span class="dot"></span></span>
      </label>
    </div>

    <div class="rates-list" id="ratesList" role="table" aria-label="Exchange rates list">
      <div class="row header" role="row">
        <div> </div>
        <div>Amount</div>
        <div>Change (24h)</div>
        <div>Chart (24h)</div>
        <div></div>
      </div>

      <!-- USD row (base) -->
      <div class="row usd" role="row" data-code="USD" data-rate="1">
        <div style="display:flex;align-items:center;gap:12px">
          <div class="currency">
            <div class="flag">🇺🇸</div>
            <div style="color: #fff;">
              <div style="font-weight:800">US Dollar</div>
              <div style="opacity:.9;font-size:13px">USD</div>
            </div>
          </div>
        </div>
        <div class="amt" role="cell">1</div>
        <div class="change" role="cell">—</div>
        <div class="spark"><canvas width="110" height="36" data-series="0.82,0.84,0.85,0.86,0.86,0.863,0.862"></canvas></div>
        <div><button class="send">Send</button></div>
      </div>

      <!-- EURO -->
      <div class="row" role="row" data-code="EUR" data-rate="0.86095" data-change="+0.46%">
        <div style="display:flex;align-items:center;gap:12px">
          <div class="currency">
            <div class="flag">🇪🇺</div>
            <div style="color:#072039">
              <div style="font-weight:800">Euro</div>
              <div style="opacity:.7;font-size:13px">EUR</div>
            </div>
          </div>
        </div>
        <div class="amt" role="cell">0.86095</div>
        <div class="change" role="cell">+0.46%</div>
        <div class="spark"><canvas width="110" height="36" data-series="0.84,0.845,0.848,0.853,0.861,0.859,0.86095"></canvas></div>
        <div><button class="send">Send</button></div>
      </div>

      <!-- GBP -->
      <div class="row" role="row" data-code="GBP" data-rate="0.74487" data-change="+0.31%">
        <div style="display:flex;align-items:center;gap:12px">
          <div class="currency">
            <div class="flag">🇬🇧</div>
            <div style="color:#072039">
              <div style="font-weight:800">British Pound</div>
              <div style="opacity:.7;font-size:13px">GBP</div>
            </div>
          </div>
        </div>
        <div class="amt" role="cell">0.74487</div>
        <div class="change" role="cell">+0.31%</div>
        <div class="spark"><canvas width="110" height="36" data-series="0.72,0.725,0.73,0.738,0.742,0.745,0.74487"></canvas></div>
        <div><button class="send">Send</button></div>
      </div>

      <!-- JPY -->
      <div class="row" role="row" data-code="JPY" data-rate="148.25" data-change="+0.51%">
        <div style="display:flex;align-items:center;gap:12px">
          <div class="currency">
            <div class="flag">🇯🇵</div>
            <div style="color:#072039">
              <div style="font-weight:800">Japanese Yen</div>
              <div style="opacity:.7;font-size:13px">JPY</div>
            </div>
          </div>
        </div>
        <div class="amt" role="cell">148.25</div>
        <div class="change" role="cell">+0.51%</div>
        <div class="spark"><canvas width="110" height="36" data-series="145,146.5,147.2,147.9,148.1,148.4,148.25"></canvas></div>
        <div><button class="send">Send</button></div>
      </div>

      <!-- CAD -->
      <div class="row" role="row" data-code="CAD" data-rate="1.3778" data-change="+0.19%">
        <div style="display:flex;align-items:center;gap:12px">
          <div class="currency">
            <div class="flag">🇨🇦</div>
            <div style="color:#072039">
              <div style="font-weight:800">Canadian Dollar</div>
              <div style="opacity:.7;font-size:13px">CAD</div>
            </div>
          </div>
        </div>
        <div class="amt" role="cell">1.3778</div>
        <div class="change" role="cell">+0.19%</div>
        <div class="spark"><canvas width="110" height="36" data-series="1.34,1.35,1.36,1.37,1.377,1.378,1.3778"></canvas></div>
        <div><button class="send">Send</button></div>
      </div>

    </div>
  </div>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

  <script>
    // Ensure DOM ready
    $(function(){

      // Utility: parse amount from editable div (strip $ and commas)
      function parseAmount(){
        var txt = $('#amount').text().trim();
        txt = txt.replace(/\$/g,'').replace(/,/g,'').replace(/\s/g,'');
        if(txt === '' ) return 0;
        var v = parseFloat(txt);
        return isNaN(v) ? 0 : v;
      }

      // Write amount nicely (format with $ and two decimals)
      function writeAmount(val){
        // if user typed non-number keep as-is
        $('#amount').text('$' + Number(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 6}));
      }

      // draw sparklines (small green line on light background)
      function drawSparklines(){
        $('.spark canvas').each(function(){
          var c = this;
          var ctx = c.getContext('2d');
          var raw = $(this).attr('data-series') || '';
          var arr = raw.split(',').map(Number).filter(n => !isNaN(n));
          if(arr.length < 2) return;
          // normalize
          var w = c.width, h = c.height, pad = 6;
          var min = Math.min.apply(null,arr), max = Math.max.apply(null,arr);
          var range = (max - min) || 1;
          ctx.clearRect(0,0,w,h);

          // background faint
          ctx.fillStyle = 'rgba(30,120,60,0.06)';
          ctx.beginPath();
          ctx.moveTo(pad, h - pad);
          for(var i=0;i<arr.length;i++){
            var x = pad + (i/(arr.length-1))*(w - 2*pad);
            var y = pad + (1 - (arr[i]-min)/range)*(h - 2*pad);
            ctx.lineTo(x,y);
          }
          ctx.lineTo(w-pad, h-pad);
          ctx.closePath();
          ctx.fill();

          // line
          ctx.beginPath();
          for(var i=0;i<arr.length;i++){
            var x = pad + (i/(arr.length-1))*(w - 2*pad);
            var y = pad + (1 - (arr[i]-min)/range)*(h - 2*pad);
            if(i===0) ctx.moveTo(x,y); else ctx.lineTo(x,y);
          }
          ctx.strokeStyle = '#1f9d58';
          ctx.lineWidth = 2;
          ctx.stroke();

          // end dot
          ctx.beginPath();
          ctx.fillStyle = '#166e3a';
          var lastX = pad + ((arr.length-1)/(arr.length-1))*(w - 2*pad);
          var lastY = pad + (1 - (arr[arr.length-1]-min)/range)*(h - 2*pad);
          ctx.arc(lastX,lastY,2.5,0,Math.PI*2);
          ctx.fill();
        });
      }

      // Initial sparkline drawing
      drawSparklines();

      // Conversion logic
      function convert(){
        // read selections
        var from = $('#fromSelect').data('currency');
        var to = $('#toSelect').data('currency');
        var amt = parseAmount();
        // find rate rows for to/from
        var fromRate = $('[data-code="'+from+'"]').data('rate');
        var toRate = $('[data-code="'+to+'"]').data('rate');
        // We store rates as "how many units per 1 USD" in the table (USD = 1).
        // To convert from 'from' to 'to': amount_in_usd = amt / fromRate; result = amount_in_usd * toRate
        // Example: from USD to EUR when fromRate=1, toRate=0.86095 => result = amt * 0.86095
        var result = (amt / fromRate) * toRate;
        // Write result into the "to" display area on top by updating toSelect label area (also show number)
        // For clarity, update the "to" select display to show numeric converted value under it (transient).
        // We'll show a little alert-like text under the To select using title attribute.
        $('#toSelect').find('div').last().find('.converted').remove();
        var formatted = Number(result).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:6});
        $('#toSelect > div:last-child').append('<div class="converted" style="font-size:13px;color:var(--muted);margin-top:4px">= '+formatted+' '+to+'</div>');
        return result;
      }

      // Convert on button click
      $('#convertBtn').on('click', function(){
        convert();
      });

      // Swap currencies
      $('#swapBtn').on('click', function(){
        var a = $('#fromSelect').data('currency');
        var b = $('#toSelect').data('currency');
        // swap data and inner emoji/text
        var fromHtml = $('#fromSelect').php();
        var toHtml = $('#toSelect').php();
        var fromData = $('#fromSelect').data('currency');
        var toData = $('#toSelect').data('currency');

        $('#fromSelect').data('currency', toData).php(toHtml);
        $('#toSelect').data('currency', fromData).php(fromHtml);

        // remove converted result tag
        $('#toSelect').find('.converted').remove();
      });

      // Clicking a currency row sets it into either From (left-click) or To (right-click)
      $('#ratesList .row').on('click', function(e){
        var code = $(this).data('code');
        if(!code) return;
        // left-click sets From, shift+click sets To
        if(e.shiftKey){
          // set toSelect
          var flag = $(this).find('.flag').text();
          var name = $(this).find('.currency div:nth-child(2)').text() || code;
          $('#toSelect').data('currency', code).php('<div style="font-size:18px; margin-right:6px">'+flag+'</div><div><div style="font-weight:700">'+code+'</div><div style="font-size:12px;color:var(--muted)">'+name+'</div></div>');
          $('#toSelect').find('.converted').remove();
        } else {
          // set from
          var flag = $(this).find('.flag').text();
          var name = $(this).find('.currency div:nth-child(2)').text() || code;
          $('#fromSelect').data('currency', code).php('<div style="font-size:18px; margin-right:6px">'+flag+'</div><div><div style="font-weight:700">'+code+'</div><div style="font-size:12px;color:var(--muted)">'+name+'</div></div>');
          $('#toSelect').find('.converted').remove();
        }
      });

      // Inverse toggle: toggles all displayed amount cells between base-of-USD and inverse
      $('#inverseToggle').on('change', function(){
        var inverse = $(this).is(':checked');
        $('#ratesList .row').each(function(){
          var rate = $(this).data('rate');
          var $amt = $(this).find('.amt');
          if(!rate) return;
          if(inverse){
            // show 1/rate (rounded)
            var inv = 1 / rate;
            $amt.text(Number(inv).toFixed(6).replace(/\.?0+$/,''));
          } else {
            // show original rate (formatting)
            // If the row is USD (rate=1) show 1
            $amt.text(Number(rate).toLocaleString(undefined,{maximumFractionDigits:6}));
          }
        });
      });

      // Make amount editable nicer: when focused, remove $; on blur format
      $('#amount').on('focus', function(){
        var v = $(this).text().trim().replace(/\$/g,'').replace(/,/g,'');
        $(this).text(v);
      }).on('blur', function(){
        var v = parseAmount();
        writeAmount(v);
      });

      // Allow pressing Enter in amount to trigger convert
      $('#amount').on('keydown', function(e){
        if(e.key === 'Enter'){ e.preventDefault(); $('#convertBtn').click(); $(this).blur(); }
      });

      // Keep sparklines responsive on window resize
      var rto;
      $(window).on('resize', function(){ clearTimeout(rto); rto = setTimeout(drawSparklines, 120); });

      // initialize amount formatting
      writeAmount(1.00);

      // populate initial "converted" result so it looks like screenshot
      $('#convertBtn').click();
    });
  </script>

</body>
</html>
