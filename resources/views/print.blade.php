<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            position: relative;
            background-color: #eee;
            font-size: 85%;
        }

        #print {
            position: fixed;
        }

        #content {
            width: 220mm;
            padding: 15mm 5mm 15mm 20mm;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 0 5px rgb(0 0 0 / 10%);
        }
    </style>
    <script>
        function printPDF() {
                var printWindow = window.open('', 'G7 Autocare', 'height=1600,width=920');
                printWindow.document.write('<!DOCTYPE html><html><head>');
                printWindow.document.write(`<title></title>`);
                printWindow.document.write(`<link href="{{ asset('css/pdf.css') }}" rel="stylesheet" type="text/css" />`);
                printWindow.document.write(`
                <style>
                    @page {
                        size: A4 portrait;
                    }
                    body {
                        margin: 0px;
                    }

                    .MsoBodyTextIndent {
                        margin-right: 0!important;
                    }
                </style>
                `);
                printWindow.document.write('</head><body >');
                printWindow.document.write(document.getElementById('content').outerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.onload = function() {
                    printWindow.print();
                }
            }
    </script>
</head>

<body>
    <button onclick="printPDF()" style="padding: 5px 10px" class="d-print-none" id="print">In</button>
    <div style="display: flex; justify-content: center">
        <div id="content">
            <div style="width: 100%">{!! $template !!}</div>
        </div>
    </div>
</body>

<script>
	printPDF();
</script>

</html>
