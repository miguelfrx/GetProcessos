<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.5;
        }

        .header-logo {
            text-align: left;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px;
        }

        /* Bloco de Informações do Processo e Requerente */
        .info-box {
            margin-bottom: 30px;
            border-left: 3px solid #0056b3;
            padding-left: 15px;
        }

        .info-box p {
            margin: 2px 0;
            font-size: 10pt;
        }

        .requerente-section {
            margin-top: 15px;
            font-weight: bold;
        }

        /* Caixa de Texto Sempre Igual */
        .texto-fixo {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            font-style: italic;
            font-size: 10pt;
        }

        .assunto-header {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
        }

        .conteudo-dinamico {
            margin-top: 20px;
            min-height: 200px;
            text-align: justify;
        }

        /* Rodapé / Assinaturas */
        .assinatura-section {
            margin-top: 50px;
            text-align: center;
            width: 300px;
            float: right;
        }

        .assinatura-linha {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header-logo">
        {{-- <img src="{{ $logo }}" class="logo"> --}}
        <h2 style="color: #0056b3;">ESPOSENDE AMBIENTE</h2>
    </div>

    <div class="info-box">
        <p><strong>Processo CME Nº:</strong> {{ $processo_cme }}</p>
        <p><strong>Processo EAmb Nº:</strong> {{ $processo_eamb }}</p>
        <p><strong>Data Entrada:</strong> {{ $data_entrada }}</p>
        <p><strong>ID Aditamento:</strong> {{ $id_aditamento }}</p>
        <p><strong>Data Atual:</strong> {{ $data_atual }}</p>

        <div class="requerente-section">
            <p>Requerente: {{ $requerente }}</p>
            <p>Local: {{ $local_morada }}</p>
        </div>
    </div>

    <div class="texto-fixo">
        No âmbito das competências delegadas pela Câmara Municipal de Esposende, a Esposende Ambiente informa que o processo acima identificado foi analisado tecnicamente de acordo com os regulamentos em vigor...
    </div>

    <div class="assunto-header">
        ASSUNTO: {{ $assunto }}
    </div>

    <div class="conteudo-dinamico">
        {!! $conteudo !!}
    </div>

    <div style="margin-top: 30px;">
        Com os melhores cumprimentos,
    </div>

    <div class="assinatura-section">
        <p>{{ $data_atual }}</p>
        <div class="assinatura-linha">
            <strong>{{ $tecnico_nome }}</strong><br>
            {{ $tecnico_cargo }}
        </div>
    </div>

</body>

</html>