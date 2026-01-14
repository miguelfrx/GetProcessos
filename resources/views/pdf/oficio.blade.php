@php
/**
* CONVERSÃO DO LOGOTIPO PARA BASE64
* Nome do ficheiro: esposende-ambiente-alt-1920x295.png
*/
$logoName = 'esposende-ambiente-alt-1920x295.png';
$logoPath = public_path('img/' . $logoName);
$base64 = '';
if (file_exists($logoPath)) {
$type = pathinfo($logoPath, PATHINFO_EXTENSION);
$data = file_get_contents($logoPath);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
@endphp

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <title>Despacho EAmb - {{ $processo->numero_eamb }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        /* 1. TOPO: Logotipo */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #005596;
            padding-bottom: 10px;
        }

        .header img {
            width: 100%;
            max-width: 400px;
            height: auto;
        }

        /* 2. DADOS DO PROCESSO */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            color: #005596;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
            border-bottom: 1px solid #eee;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
            border: 1px solid #f5f5f5;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            font-size: 8px;
            color: #777;
            text-transform: uppercase;
            display: block;
        }

        /* 3. NORMAS GERAIS */
        .normas-box {
            font-size: 9px;
            color: #555;
            background: #fdfdfd;
            padding: 10px;
            border: 1px solid #eee;
            margin-bottom: 20px;
            text-align: justify;
        }

        /* 4. ASSUNTO */
        .assunto-header {
            font-size: 13px;
            font-weight: bold;
            color: #005596;
            margin-top: 15px;
            text-transform: uppercase;
        }

        .texto-padrao {
            font-style: italic;
            color: #444;
            margin-bottom: 15px;
            padding: 5px 0;
            text-align: justify;
        }

        /* 5. TEXTO PERSONALIZADO */
        .texto-personalizado {
            font-size: 11px;
            text-align: justify;
            margin-bottom: 20px;
            padding-top: 10px;
        }

        /* BLOCO DE MATERIAIS */
        .materials-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px;
            margin-bottom: 20px;
        }

        /* 6. ASSINATURA */
        .signature {
            margin-top: 50px;
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #aaa;
        }
    </style>
</head>

<body>

    <div class="header">
        @if($base64)
        <img src="{{ $base64 }}" alt="Logo">
        @endif
    </div>

    <div class="section-title">Identificação do Processo e Requerente</div>
    <table class="info-table">
        <tr>
            <td width="33%"><span class="label">Nº EAmb</span><strong>{{ $processo->numero_eamb }}</strong></td>
            <td width="33%"><span class="label">Nº CME</span><strong>{{ $processo->numero_cme ?? '---' }}</strong></td>
            <td width="34%"><span class="label">Data Emissão</span>{{ $data_atual }}</td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">Requerente</span><strong>{{ $processo->requerente }}</strong></td>
            <td><span class="label">NIF</span>{{ $processo->nif ?? '---' }}</td>
        </tr>
    </table>

    <div class="section-title">Normas e Enquadramento Legal</div>
    <div class="normas-box">
        Nos termos do Regulamento de Serviço de Gestão de Resíduos Urbanos e de Limpeza Pública, e em conformidade com as normas técnicas da Esposende Ambiente, E.E.M., procede-se à análise técnica do pedido. O presente despacho vincula as partes às condições de execução e segurança em vigor no concelho de Esposende.
    </div>

    <div class="assunto-header">
        ASSUNTO: {{ $assunto_titulo }}
    </div>
    <div class="texto-padrao">
        {!! nl2br(e($assunto_texto_padrao)) !!}
    </div>

    <div class="section-title">Parecer / Informação Técnica Adicional</div>
    <div class="texto-personalizado">
        {!! nl2br(e($texto_caixa_detalhes)) !!}
    </div>

    @if(isset($materiais) && !empty($materiais))
    <div class="section-title">Materiais e Equipamentos Utilizados</div>
    <div class="materials-box">
        {!! nl2br(e($materiais)) !!}
    </div>
    @endif

    <div class="signature">
        <p>Esposende, {{ $data_atual }}</p>
        <div style="margin-top: 40px;">
            ________________________________________________<br>
            <strong style="text-transform: uppercase;">{{ $processo->tecnica->nome ?? 'Técnico Responsável' }}</strong><br>
            Esposende Ambiente, E.E.M.
        </div>
    </div>

    <div class="footer">
        Esposende Ambiente, E.E.M. | NIF: 504 532 505 | www.esposendeambiente.pt
    </div>

</body>

</html>