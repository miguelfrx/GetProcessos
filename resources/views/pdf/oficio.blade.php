<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ofício - {{ $processo->numero_eamb }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #005596;
            padding-bottom: 10px;
            /* Corrigido: era 'pb' */
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #005596;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            color: #666;
        }

        .content {
            margin-top: 30px;
            text-align: justify;
        }

        .materials-box {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
            /* Corrigido: era 'pt' */
        }

        .signature {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">Esposende Ambiente, E.E.M.</div>
        <div style="font-size: 10px;">Gestão de Águas e Resíduos</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <span class="label">Nº Processo EAmb:</span><br>
                <strong>{{ $processo->numero_eamb }}</strong>
            </td>
            <td width="50%">
                <span class="label">Nº Processo CME:</span><br>
                <strong>{{ $processo->numero_cme ?? '---' }}</strong> {{-- Correção do erro aqui --}}
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">Data de Emissão:</span><br>
                {{ $data_atual }}
            </td>
            <td>
                <span class="label">ID Aditamento:</span><br>
                {{ $id_aditamento }}
            </td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <span class="label">Requerente:</span><br>
        <strong>{{ $processo->requerente }}</strong><br>
        {{ $processo->morada_localizacao }}
    </div>

    <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px;">
        <span class="label">Assunto:</span><br>
        <strong style="font-size: 14px;">{{ $assunto_selecionado }}</strong>
    </div>

    <div class="content">
        {!! nl2br(e($texto_corpo)) !!}
    </div>

    @if($materiais)
    <div class="materials-box">
        <span class="label">Materiais / Equipamentos Aplicados:</span><br>
        <div style="margin-top: 5px;">
            {!! nl2br(e($materiais)) !!}
        </div>
    </div>
    @endif

    <div class="signature">
        <p>Esposende, {{ $data_atual }}</p>
        <div style="margin-top: 40px;">
            ________________________________________________<br>
            <strong>{{ $processo->tecnica->nome ?? 'Serviços Técnicos' }}</strong><br>
            Esposende Ambiente
        </div>
    </div>

    <div class="footer">
        Esposende Ambiente, E.E.M. | Rua da Senhora da Saúde, Esposende | NIF: 504 532 505
    </div>

</body>

</html>