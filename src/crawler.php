<?php 

namespace Focus599Dev\crawlerOutrosImps;

include_once realpath(__DIR__ . '/../anticaptcha') . '/anticaptcha.php';

include_once realpath(__DIR__ . '/../anticaptcha') . '/imagetotext.php';

use AntiCaptcha\ImageToText;
use DOMDocument;
use DomXpath;
use Mpdf\Mpdf;

class Crawler{


	protected $urls = array(
		'http://www31.receita.fazenda.gov.br/SicalcWeb/UF.asp?AP=P&Person=N&TipTributo=2&FormaPagto=1',
		'http://www31.receita.fazenda.gov.br/SicalcWeb/municipio.asp?AP=P&TipTributo=2&FormaPagto=1&Person=N',
		'http://www31.receita.fazenda.gov.br/SicalcWeb/princ.asp?AP=P&TipTributo=2&FormaPagto=1&Person=N',
		'http://www31.receita.fazenda.gov.br/SicalcWeb/PeriodoApuracao.asp?AP=P&TipTributo=2&FormaPagto=1&Person=N',
		'http://www31.receita.fazenda.gov.br/SicalcWeb/SelVenc.asp?AP=P&TipTributo=2&FormaPagto=1&Person=N',
		'http://www31.receita.fazenda.gov.br/SicalcWeb/resumo.asp?AP=P&TipTributo=2&FormaPagto=1&Person=N',
		'http://www31.receita.fazenda.gov.br/SicalcWeb/DadosContrib.asp',
		'http://www31.receita.fazenda.gov.br/Darf/senda.asp'
	);

	protected $text_html = '';

	protected $html;

	protected $patch_captcha;

	public $data = array();

	protected $filePDF;

	protected $keyCaptch;

	protected $fase = 0;

	protected $endFase = 7;

	protected $cookieName;

	protected $header = array(
	    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
	    'Accept-Encoding: gzip, deflate, br',
	    'Accept-Language: en-US,en;q=0.9,pt;q=0.8',
	    'Cache-Control: no-cache',
	    'Host: www.receita.fazenda.gov.br',
	    'Pragma: no-cache',
	    'Referer: http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/SicalcWeb/default.asp?TipTributo=2&FormaPagto=1',
	    'Upgrade-Insecure-Requests: 1',
	    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36'
	);

	public $error;

	function __construct($data){

		set_time_limit(0);

		error_reporting(1);

		$this->clearSessionCurl();

		$this->data = $data;

		$this->cookieName = $this->generateRandomString() . '.txt';

		if (session_status() == PHP_SESSION_NONE)
            session_start();
	}

	function __destruct() {
       $this->clearSessionCurl();
   	}

	private function generateRandomString($length = 10) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	private function clearSessionCurl(){
		unlink(realpath(__DIR__ . '/../') . $this->cookieName);
	}

	public function fase_0(){
		
		$html = $this->execCurl($this->urls[$this->fase], 'GET', null);

		$data = array(
			'ufdesc' => $this->data['ufdesc'],
			'js' => 's',
			'UF' => $this->data['UF'],
		);

		$html = $this->execCurl($this->urls[$this->fase + 1], 'POST', $data, null, false);

		$this->text_html = $html;

	}

	public function fase_1(){

		$data = array(
			'ufdesc' => $this->data['ufdesc'],
			'js' => 's',
			'UF' => $this->data['UF'],
			'municipio' => $this->data['municipio'],

		);

		$html = $this->execCurl($this->urls[$this->fase + 1], 'POST', $data, null, false);

		$this->text_html = $html;
			
	}

	public function fase_2(){

		$data = array(
			'Historico' => '',
			'DatPgtTex' => '',
			'DatPgtAge' => '',
			'UF' => '',
			'Municipio' => '',
			'Tipo' => '',
			'PADesFormatada' => '',
			'PeriodoAux' => '',
			'TipoAcao' => '',
			'DTUltimoDiaMes' => '',
			'VezSubmit' => '',
			'TipoBrowser' => '',
			'VersaoBrowser' => '',
			'TipoDarf' => '1',
			'ValCotReaTex1' => '',
			'js' => 's',
			'DataHoraSubmissao' => $this->DataHoraFim(0,0,10),
			'DataDoServidor' => '',
			'MesSelic' => '',
			'AnoSelic' => '',
			'UltDtSelic' => '',
			'CodReceita' => $this->data['CodReceita'],
		);
		
		$this->html = new DOMDocument();

		$this->html->loadHTML($this->text_html);

		$data = $this->fillPost($data);

		$data['CodReceita'] = $this->data['CodReceita'];

		$data['DataHoraSubmissao'] = $this->DataHoraFim(0,0,10);

		$data['TipoDarf'] = 1;

		$data['js'] = 's';
		
		$data['TipoAcao'] = 'I';

		$data['DTUltimoDiaMes'] = date('t/m/Y');

		$data['VezSubmit'] = 0;	

		$data['TipoBrowser'] = 'Darfns.asp';	
		
		$this->data = array_merge($this->data, $data);	

		$html = $this->execCurl($this->urls[$this->fase + 1], 'POST', $data, null, false);

		$this->text_html = $html;

	}

	public function fase_3(){

		$data = array(
			'PagCont' => '',
			'DTUltimoDiaMes' => '',
			'MesSelic' => '',
			'AnoSelic' => '',
			'UltDtSelic' => '',
			'DiaDatPgtTex' => '',
			'MesDatPgtTex' => '',
			'AnoDatPgtTex' => '',
			'Historico' => '',
			'UF' => '',
			'COTAS' => '',
			'Municipio' => '',
			'ContinuaPendencia' => '',
			'CodReceita' => '',
			'CodTributo' => '',
			'PADesFormatada' => '',
			'DatPgtTex' => '',
			'DatPgtAge' => '',
			'MultaIsolada' => '',
			'LancOficio' => '',
			'TipoDarf' => '',
			'CNPJCPF' => '',
			'TipoExtraJud' => '',
			'DTVCTO' => '',
			'CInicioPeriodicidade' => '', 
			'CFimPeriodicidade' => '',
			'datacalculada' => '',
			'ValCotReaTex1' => '',
			'TipoAcao' => '',
			'PeriodoAux' => '',
			'Exercicio' => '',
			'VersaoBrowser' => '',
			'js' => 's',
			'TipoBrowser' => 'Darfns.asp',
			'DataDoServidor' => '', 
			'CD_TIPO_CALCULO' => '',
			'fer_nac_Event' => '',
			'totfernacEvent' => '',
			'fer_nac_fixo' => '',
			'totfernacfixo' => '', 
			'fer_est_fixo' => '',
			'totferestfixo' => '0',
			'fer_est_Event' => '',
			'totferestEvent' => '0',
			'fer_munic_fixo' => '',
			'totfermunicfixo' => '0',
			'fer_munic_Event' => '',
			'totfermunicEvent' => '0',
			'datalimite' => '',
			'CInicioPeriodicidade1' => '',
			'CFimPeriodicidade1' => '',
			'CInicioPeriodicidade2' => '',
			'CFimPeriodicidade2' => '',
			'CInicioPeriodicidade3' => '',
			'CFimPeriodicidade3' => '',
			// 'CInicioPeriodicidade4' => '',
			// 'CFimPeriodicidade4' => '',
			// 'CInicioPeriodicidade5' => '',
			// 'CFimPeriodicidade5' => '',
			// 'CInicioPeriodicidade6' => '',
			// 'CFimPeriodicidade6' => '',
			// 'CInicioPeriodicidade7' => '',
			// 'CFimPeriodicidade7' => '',
			// 'CInicioPeriodicidade8' => '',
			// 'CFimPeriodicidade8' => '',
			'TotalPeriodicidade' => '',
			'periodo' => '',
			'PA' => '',
			'TxtValRec' => '',
		);

		$this->html = new DOMDocument();

		$this->html->loadHTML($this->text_html);

		$data = $this->fillPost($data);

		$data['periodo'] = $this->data['periodoType'];
		
		$data['PeriodoAux'] = $this->data['periodoType'];

		$data['PA'] = $this->data['periodo'];

		$data['TxtValRec'] = $this->data['ValorPrincipal'];

		$data['PADesFormatada'] = preg_replace('/\D/', '', $data['PA']);

		$data['LancOficio'] = 0;

		$data['MultaIsolada'] = 0;

		$data['TipoExtraJud'] = 0;

		$data['TipoExtraJud'] = 0;

		$data['ValCotReaTex1'] = 'undefined';

		$data['TipoAcao'] = 'I';

		$data['js'] = 's';

		$this->data = array_merge($this->data, $data);

		$html = $this->execCurl($this->urls[$this->fase + 1], 'POST', $data, null, false);

		$this->text_html = $html;

	}

	public function fase_4(){

		$data = array(
			'PagCont' => '',
			'DataHoraSubmissao' => '',
			'PerFormatado' => '',
			'DT_Consolidacao' => '',
			'DiaDatPgtTex' => '',
			'MesDatPgtTex' => '',
			'AnoDatPgtTex' => '',
			'Historico' => '',
			'UF' => '',
			'COTAS' => '',
			'Municipio' => '',
			'ContinuaPendencia' => '',
			'CodReceita' => '',
			'CodTributo' => '',
			'Periodo' => '',
			'PADesFormatada' => '',
			'TxtValRec' => '',
			'DatPgtTex' => '',
			'DatPgtAge' => '',
			'MultaIsolada' => '',
			'LancOficio' => '',
			'TipoDarf' => '',
			'CNPJCPF' => '',
			'TipoExtraJud' => '',
			'DTVCTO' => '',
			'UltDtSelic' => '',
			'Exercicio' => '',
			'VersaoBrowser' => '',
			'js' => 's',
			'TipoBrowser' => '',
			'DataDoServidor' => '',
			'CD_TIPO_CALCULO' => '',
			'PA' => '',
			'CD_TIPO_DATA_VENCIMENTO' => '',
			'mVcto' => '',
			'Referencia' => '',
		);

		$this->html = new DOMDocument();

		$this->html->loadHTML($this->text_html);

		$data = $this->fillPost($data);

		$data['DataHoraSubmissao'] = '';

		$data['DT_Consolidacao'] = date('d/m/Y');
		
		$data['DTVCTO'] = '';

		$data['mVcto'] = '';

		$xpath = new DomXpath($this->html);

		foreach ($xpath->query('//select[@name="mVcto"]/option[@selected]') as $rowNode) {

			$data['mVcto'] = $rowNode->getAttribute('value');

		}

		$data['DTVCTO'] = $data['mVcto'];

		$data['MultaIsolada'] = 0;

		$data['LancOficio'] = 0;

		$data['TipoExtraJud'] = 0;
		
		$data['js'] = 's';

		$this->data = array_merge($this->data, $data);

		$html = $this->execCurl($this->urls[$this->fase + 1], 'POST', $data, null, false);

		$this->text_html = $html;

	}

	public function fase_5(){

		$data = array(
			'PagCont' => 'branco.asp',
			'PerFormatado' => '',
			'Historico' => '',
			'UF' => '',
			'Municipio' => '',
			'ContinuaPendencia' => 'N',
			'TipTributoReceita' => '2',
			'VersaoBrowser' => '',
			'js' => 's',
			'TipoBrowser' => 'Darfns.asp',
			'Referencia' => '',
			'DatPgtAge' => '',
			'DataDoServidor' => '',
			'CD_TIPO_DATA_VENCIMENTO' => '',
			'CD_TIPO_CALCULO' => '',
			'DiaDatPgtTex' => '',
			'MesDatPgtTex' => '',
			'AnoDatPgtTex' => '',
			'CodReceita' => '',
			'CodTributo' => '',
			'Periodo' => '',
			'TxtValRec' => '',
			'DT_Consolidacao' => '',
			'DatPgtTex' => '',
			'MultaIsolada' => '',
			'LancOficio' => '',
			'TipoDarf' => '',
			'CNPJCPF' => '',
			'TipoExtraJud' => '',
			'DTVCTO' => '',
			'DiaDatVencMulTex' => '',
			'MesDatVencMulTex' => '',
			'AnoDatVencMulTex' => '',
			'PercMul' => '',
			'PA' => '',
			'PADesFormatada' => '',
			'AP' => '',
			'FormaPagto' => '',
			'TipTributo' => '',
			'Person' => '',
			'ANO_PERIODO' => '',
			'MES_PERIODO' => '',
			'DIA_PERIODO' => '',
			'DT_VENCIMENTO_MULTA' => '',
			'DT_PRORROGACAO' => '',
			'VA_CT_PRINCIPAL' => '',
			'CD_MOEDA' => '',
			'PE_MULTA_OFICIO' => '',
			'CD_IDENTIFICACAO_CT' => '',
			'DT_LIMITE_PAGAMENTO' => '',
			'IN_REDUCAO_MULTA' => '',
			'NU_QUOTA' => '',
			'COTAS' => '',
			'VA_IMPOSTO_ATUALIZADO' => '',
			'VA_MULTA_MORA_ATUALIZADO' => '',
			'VA_JUROS_MORA_IMPOSTO_ATUALIZADO' => '',
			'VA_MULTA_OFICIO_ATUALIZADO' => '',
			'VA_SOMATORIO_JUROS_MORA' => '',
			'VA_PERCENTUAL_MULTA_MORA' => '',
			'VA_PERCENTUAL_JUROS_MORA_IMPOSTO' => '',
			'VA_PERCENTUAL_JUROS_MORA_MULTA' => '',
			'DT_ATUALIZACAO_MONETARIA' => '',
			'DT_DATA_CONSOLIDACAO' => '',
			'VA_PERCENTUAL_REDUCAO_MULTA' => '',
			'VA_TOTAL_DEVIDO' => '',
			'DT_PA_CALCULO' => '',
			'DT_PA' => '',
			'Define_Atualizacao_Bancos' => '',
			'Num_Princ' => '',
			'Num_DV' => '',
			'txtToken_captcha_serpro_gov_br' => '',
			'txtTexto_captcha_serpro_gov_br' => '',
		);

		$this->html = new DOMDocument();

		$this->html->loadHTML($this->text_html);

		$data = $this->fillPost($data);

		$data['js'] = 's';
		
		$data['ContinuaPendencia'] = 'N';

		$data['TipTributoReceita'] = '2';

		$data['TipoBrowser'] = 'Darfns.asp';

		$dateAux = new \DateTime($this->convertDate($data['DT_Consolidacao']));

		// $dateAux->modify('+1 day');

		$data['DT_Consolidacao'] = $dateAux->format('d/m/Y');

		$data['MultaIsolada'] = 0;

		$data['LancOficio'] = 0;

		$data['TipoExtraJud'] = 0;

		$data['PE_MULTA_OFICIO'] = 0;

		if (!$data['VA_PERCENTUAL_JUROS_MORA_MULTA'])
			$data['VA_PERCENTUAL_JUROS_MORA_MULTA'] = 0;

		$data['DT_DATA_CONSOLIDACAO'] = $data['DT_Consolidacao'];
		
		if (!$data['VA_PERCENTUAL_REDUCAO_MULTA'])
			$data['VA_PERCENTUAL_REDUCAO_MULTA'] = 0;

		if (!$data['VA_MULTA_OFICIO_ATUALIZADO'])
			$data['VA_MULTA_OFICIO_ATUALIZADO'] = 0;

		if (!$data['VA_MULTA_MORA_ATUALIZADO'])
			$data['VA_MULTA_MORA_ATUALIZADO'] = 0;

		if (!$data['VA_JUROS_MORA_IMPOSTO_ATUALIZADO'])
			$data['VA_JUROS_MORA_IMPOSTO_ATUALIZADO'] = 0;
		
		if (!$data['VA_MULTA_OFICIO_ATUALIZADO'])
			$data['VA_MULTA_OFICIO_ATUALIZADO'] = 0;
		
		if (!$data['VA_JUROS_MORA_MULTA_ATUALIZADO'])
			$data['VA_JUROS_MORA_MULTA_ATUALIZADO'] = 0;

		if (!$data['VA_SOMATORIO_JUROS_MORA'])
			$data['VA_SOMATORIO_JUROS_MORA'] = 0;
		
		if (!$data['VA_PERCENTUAL_MULTA_MORA'])
			$data['VA_PERCENTUAL_MULTA_MORA'] = 0;

		if (!$data['VA_PERCENTUAL_JUROS_MORA_IMPOSTO'])
			$data['VA_PERCENTUAL_JUROS_MORA_IMPOSTO'] = 0;

		if (!$data['VA_PERCENTUAL_JUROS_MORA_MULTA'])
			$data['VA_PERCENTUAL_JUROS_MORA_MULTA'] = 0;
		
		$data['Num_Princ'] = substr($this->data['cnpj'], 0,12);

		$data['Num_DV'] = substr($this->data['cnpj'],12, 2);

		$path  = realpath(__DIR__ . '/../tmp') . '/' . date('YmdHsi') . '.png';

		$dataCaptch = $this->getImageFromUrl($path, $this->html->getElementById('captcha')->getAttribute('data-clienteid'));

		if (!is_file($path)){

	        $this->logError('Não foi possivel achar a imagem do captch');

			throw new \Exception("Não foi possivel achar o captch");
		}

		$text_capcth = $this->resolveCaptcha($dataCaptch['path']);

		try {
			
			unlink($dataCaptch['path']);

		} catch (\Exception $e) {
			
			var_dump($e->getMessage());	
		}

		$data['txtTexto_captcha_serpro_gov_br'] = $text_capcth;
		
		$data['txtToken_captcha_serpro_gov_br'] = $dataCaptch['token'];

		$this->data = array_merge($this->data, $data);

		$html = $this->execCurl($this->urls[$this->fase + 1], 'POST', $data, null, false);

		$this->text_html = $html;

	}

	public function fase_6(){
		
		$data = array(
			'UF_SIGLA_INFORMADA' => '',
			'COTAS' => '',
			'CD_MUNICIPIO_INFORMADA' => '',
			'Municipio_Classificacao' => '',
			'UA_Classificacao' => '',
			'Exercicio' => '',
			'js' => 's',
			'TipoBrowser' => 'Darfns.asp',
			'TipTributoReceita' => '2',
			'DataDoServidor' => '',
			'NI_CONTRIBUINTE' => '',
			'NU_QUOTA' => '',
			'CD_TIPO_DATA_VENCIMENTO' => '',
			'CD_TIPO_CALCULO' => '',
			'CD_RECEITA' => '',
			'CD_TRIBUTO' => '',
			'IN_TIPO_PERIODO' => '',
			'DatPgtTex' => '',
			'MultaIsolada' => '0',
			'LancOficio' => '0',
			'TipoDarf' => '0',
			'CNPJCPF' => '0',
			'DT_VENCIMENTO_IMPOSTO' => '',
			'NU_REFERENCIA' => '',
			'DatPgtAge' => '',
			'Secao' => '',
			'Vara' => '',
			'AcaoClasse' => '',
			'Autor' => '',
			'Reu' => '',
			'Aliquota' => '',
			'BaseCalculo' => '',
			'DataHoraSubmissao' => '',
			'Define_Atualizacao_Bancos' => 's',
			'ANO_PERIODO' => '',
			'MES_PERIODO' => '',
			'DIA_PERIODO' => '',
			'DT_VENCIMENTO_MULTA' => '',
			'DT_PRORROGACAO' => '',
			'VA_CT_PRINCIPAL' => '',
			'CD_MOEDA' => '',
			'PE_MULTA_OFICIO' => '0',
			'CD_IDENTIFICACAO_CT' => '',
			'DT_LIMITE_PAGAMENTO' => '',
			'IN_REDUCAO_MULTA' => '',
			'VA_IMPOSTO_ATUALIZADO' => '',
			'VA_MULTA_MORA_ATUALIZADO' => '',
			'VA_JUROS_MORA_IMPOSTO_ATUALIZADO' => '',
			'VA_MULTA_OFICIO_ATUALIZADO' => '',
			'VA_JUROS_MORA_MULTA_ATUALIZADO' => '',
			'VA_SOMATORIO_JUROS_MORA' => '',
			'VA_PERCENTUAL_MULTA_MORA' => '',
			'VA_PERCENTUAL_JUROS_MORA_IMPOSTO' => '',
			'VA_PERCENTUAL_JUROS_MORA_MULTA' => '',
			'DT_ATUALIZACAO_MONETARIA' => '',
			'DT_DATA_CONSOLIDACAO' => '',
			'VA_PERCENTUAL_REDUCAO_MULTA' => '',
			'VA_TOTAL_DEVIDO' => '',
			'DT_PA_CALCULO' => '',
			'DT_ALIENACAO' => '',
			'radioGanho' => '',
			'Num_Princ' => '',
			'Num_DV' => '',
			'Documento' => '',
			'PagSubmit' => '',
			'versao' => '1.7.66',
			'CD_MUNICIPIO_BASE_CPF' => '',
			'CD_ORGAO_SRF_BASE_CPF' => '',
			'UF_SIGLA_BASE_CPF' => '',
			'ProgramaChamador' => '',
			'NO_NOME_CONTRIBUINTE' => '',
		);

		$this->html = new DOMDocument();

		$this->html->loadHTML($this->text_html);

		$data = $this->fillPost($data);

		$data['js'] = 's';

		$data['MultaIsolada'] = 0;

		$data['LancOficio'] = 0;

		$data['DataHoraSubmissao'] = $this->DataHoraFim(0,0,10);

		$dateAux = new \DateTime($this->convertDate($data['DT_LIMITE_PAGAMENTO']));

		// $dateAux->modify('+1 day');

		$data['DT_LIMITE_PAGAMENTO'] = $dateAux->format('d/m/Y');

		if(!$data['VA_MULTA_OFICIO_ATUALIZADO'])
			$data['VA_MULTA_OFICIO_ATUALIZADO'] = 0;

		if(!$data['VA_JUROS_MORA_MULTA_ATUALIZADO'])
			$data['VA_JUROS_MORA_MULTA_ATUALIZADO'] = 0;

		if(!$data['VA_PERCENTUAL_JUROS_MORA_MULTA'])
			$data['VA_PERCENTUAL_JUROS_MORA_MULTA'] = 0;

		if(!$data['VA_PERCENTUAL_REDUCAO_MULTA'])
			$data['VA_PERCENTUAL_REDUCAO_MULTA'] = 0;
		
		if(!$data['VA_MULTA_MORA_ATUALIZADO'])
			$data['VA_MULTA_MORA_ATUALIZADO'] = 0;
		
		if(!$data['VA_JUROS_MORA_IMPOSTO_ATUALIZADO'])
			$data['VA_JUROS_MORA_IMPOSTO_ATUALIZADO'] = 0;
		
		if(!$data['VA_MULTA_OFICIO_ATUALIZADO'])
			$data['VA_MULTA_OFICIO_ATUALIZADO'] = 0;

		if(!$data['VA_JUROS_MORA_MULTA_ATUALIZADO'])
			$data['VA_JUROS_MORA_MULTA_ATUALIZADO'] = 0;
		
		if(!$data['VA_SOMATORIO_JUROS_MORA'])
			$data['VA_SOMATORIO_JUROS_MORA'] = 0;
		
		if(!$data['VA_PERCENTUAL_MULTA_MORA'])
			$data['VA_PERCENTUAL_MULTA_MORA'] = 0;
		
		if(!$data['VA_PERCENTUAL_JUROS_MORA_IMPOSTO'])
			$data['VA_PERCENTUAL_JUROS_MORA_IMPOSTO'] = 0;
		
		if(!$data['VA_PERCENTUAL_JUROS_MORA_MULTA'])
			$data['VA_PERCENTUAL_JUROS_MORA_MULTA'] = 0;

		$data['PagSubmit'] = 0;
		

		$this->data = array_merge($this->data, $data);
		
		$html = $this->execCurl($this->urls[$this->fase + 1], 'POST', $data, null, false);

		$this->text_html = $html;

	}

	public function fase_7(){

		if (preg_match('/Aprovado pela IN\/RFB/', $this->text_html)){

			$template = file_get_contents(__DIR__ . '/../template/darf.tpl');

			$replace = array(
				'date_apur' => $this->data['DT_PA_CALCULO'],
				'nome' => $this->data['NO_NOME_CONTRIBUINTE'],
				'cnpj' => $this->formatCNPJ($this->data['NI_CONTRIBUINTE']),
				'receita' => $this->data['CD_RECEITA'],
				'referencia' => $this->data['NU_REFERENCIA'],
				'vencimento' => $this->data['DT_VENCIMENTO_IMPOSTO'],
				'valor_principal' => $this->data['ValorPrincipal'],
				'valor_multa' => $this->data['VA_MULTA_MORA_ATUALIZADO'],
				'valor_juros' => $this->data['VA_JUROS_MORA_IMPOSTO_ATUALIZADO'],
				'valor_total' => $this->data['VA_TOTAL_DEVIDO'],
				'date_valid' => $this->data['DatPgtTex'],
				'municio' => $this->data['ufdesc'],
				'date_now' => date('d/m/Y H:i:s'),
				'logo' => 'data:image/gif;base64,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',
			);

			foreach ($replace as $key => $value) {
				
				$template = str_replace("{{%$key}}", $value, $template);

			}

			$file = $this->makeRandomString() . '.pdf';

			$folder = realpath(__DIR__ . '/../pdf');

			$mpdf = new Mpdf();

			$mpdf->SetDisplayMode('fullpage');

			$mpdf->allow_charset_conversion = true;

			$mpdf->charset_in='iso-8859-4';

			$mpdf->WriteHTML(utf8_decode($template));

			$this->filePDF = $folder . '/' . $file;

			$mpdf->Output($this->filePDF, 'F');

		} else {

			$this->error[] = 'Não foi possivel gerar o a Darf.';
		}	

		print_r($this->text_html);
		var_dump('Final fase 7');
	}

	private function savePDF($html){
		
		$mpdf = new Mpdf();

		$mpdf->WriteHTML($html);

		$mpdf->Output($this->filePDF,'F');

		$file = $this->makeRandomString() . '.pdf';

		$folder = realpath(__DIR__ . '/../pdf') . '/';

		$this->filePDF = $folder . $file;

		return $this->filePDF;
	}

	public function copyFilePDF($pathTo){

		try {

			if (is_file($this->filePDF)){
				
				copy($this->filePDF, $pathTo);

				unlink($this->filePDF);

				return $pathTo;

			}

			return false;

		} catch (\Exception $e){

			$this->logError($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

			return false;
		}

		return false;

	}

	private function makeRandomString($max=6) {
	    
	    $i = 0;
	    
	    $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    
	    $keys_length = strlen($possible_keys);
	    
	    $str = "";
	    
	    while( $i < $max) {
	        
	        $rand = mt_rand(1,$keys_length-1);
	        
	        $str.= $possible_keys[$rand];
	        
	        $i++;
	    }
	    
	    return $str;
	}

	private function getImageFromUrl($path, $clientId){

		try{

			$oldHeader = $this->header;

			$this->header = array(
				'Content-Type: text/plain;charset=UTF-8',
				'Origin: http://www31.receita.fazenda.gov.br',
				'Referer: http://www31.receita.fazenda.gov.br/SicalcWeb/DadosContrib.asp',
				'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36'
			);

			$data = $this->execCurl('http://captcha2.servicoscorporativos.serpro.gov.br/captcha/1.0.0/imagem', 'POST', $clientId, null, true);

			$this->header = $oldHeader;

			$data = explode('@', $data);

			$token = $data[0];

			$base64 = $data[1];

			$r = array();

			$r['token'] = $token;
			
			$r['path'] = $path;

			file_put_contents($path, base64_decode($base64));

			return $r;

		} catch (\Exception $e){

			$this->logError($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

			return false;
		}


	}

	private function resolveCaptcha($file){
			
		if (!$this->keyCaptch)
			throw new \Exception("É necessário setar key do AntiCaptcha");
			
		$api = new ImageToText();
		
		$api->setVerboseMode(false);

		$api->setKey($this->keyCaptch);

		$api->setFile($file);

		if (!$api->createTask()) {
		    
		    return false;
		}

		$taskId = $api->getTaskId();

		if (!$api->waitForResult()) {
		   
		   return false;
		
		} else {

		    return $api->getTaskSolution();

		}
	}

	public function run(){

		try{
			
			$this->{"fase_" . $this->fase}();

			if ($this->endFase != $this->fase){
				
				$this->fase  = $this->fase + 1;

				$this->run();

			}

			return $this->isPDF();

		} catch (\Exception $e){

	        $this->logError($e->getMessage() . ' ' . $e->getLine());

			return false;

		}
	}

	public function isPDF(){
		return is_file($this->filePDF);
	}

	private function execCurl($url, $method, $data, $certificado = null, $fallowLocation = true){
		
		$httpcode = null;

		$response = null;

		try{

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);

			if ($method == 'POST')
				curl_setopt($ch, CURLOPT_POST, true);

			if ($data && is_array($data)){
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			} else if (is_string($data)){
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			}

			if ($fallowLocation)
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

			curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieName);
			
			curl_setopt($ch, CURLOPT_COOKIEFILE, realpath(__DIR__ . '/../') . $this->cookieName); //saved cookies

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	        
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

	        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$response = curl_exec($ch);

			curl_close($ch);

		} catch (\Exception $e){

            throw $e; 
            
		}
		
		return $response;
	}

		private function dataAtual(){
		
		$dataAtual = new \DateTime();
		
		$dataInvertidaDia = $this->FormataDataHora($dataAtual->format('d'));
		
		$dataInvertidaMes = $this->FormataDataHora($dataAtual->format('m'));
		
		$dataInvertidaAno = $dataAtual->format('y');
		
		$dataInvertidaHora = $this->FormataDataHora($dataAtual->format('H'));
		
		$dataInvertidaMinuto = $this->FormataDataHora($dataAtual->format('i'));
		
		$dataInvertidaSegundo = $this->FormataDataHora($dataAtual->format('s'));
		
		$dataHoraInvertida = $dataInvertidaAno . $dataInvertidaMes . $dataInvertidaDia . $dataInvertidaHora . $dataInvertidaMinuto . $dataInvertidaSegundo;
		
		return $dataHoraInvertida;
	}

	//-------------------------------

	private function DataHoraFim($h, $m, $s){
		
		$oneSecond = 1000;
		
		$oneMinute = 60 * $oneSecond;
		
		$oneHour = 60 * $oneMinute;
		
		$dataHoraInvertida = ''; 

		$dataInvertidaDia = ''; 

		$dataInvertidaMes = ''; 

		$dataInvertidaAno = ''; 

		$dataInvertidaHora = ''; 

		$dataInvertidaMinuto = '';

		$dataInvertidaSegundo = '';
		
		$dataAtual = new \DateTime();
		
		$dataInMS = time();

		$dataInMS = $dataInMS + $oneHour * $h + $oneMinute * $m + $oneSecond * $s;
		
		$dataAtual->setTimestamp($dataInMS);
		
		$dataInvertidaDia = $this->FormataDataHora($dataAtual->format('d'));
		
		$dataInvertidaMes = $this->FormataDataHora($dataAtual->format('m'));
		
		$dataInvertidaAno = $dataAtual->format('y');
		
		$dataInvertidaHora = $this->FormataDataHora($dataAtual->format('H'));
		
		$dataInvertidaMinuto = $this->FormataDataHora($dataAtual->format('i'));
		
		$dataInvertidaSegundo = $this->FormataDataHora($dataAtual->format('s'));
		
		$dataHoraInvertida = $dataInvertidaAno . $dataInvertidaMes . $dataInvertidaDia . $dataInvertidaHora . $dataInvertidaMinuto . $dataInvertidaSegundo;
		
		return $dataHoraInvertida;
	}

	//-------------------------------

	private function FormataDataHora($x){
		
		$ValorF = '0' . $x;

		$ValorF = substr($ValorF, strlen($ValorF) -2 , 2);

		return $ValorF;
	}

	private function fillPost ($post){
		
		$xpath = new DomXpath($this->html);

		foreach ($post as $key => $post_value) {

			foreach ($xpath->query('//input[@name="' . $key . '"]') as $rowNode) {

				if($rowNode->getAttribute('value'))
			    	$post[$key] = $rowNode->getAttribute('value');
			}
		}

		return $post;
	}

	private function logError($message){

		$this->error[] = $message;

		return file_put_contents(realpath(__DIR__ . '/../log') . '/log.txt', date('d/m/Y H:i:s') . ' ' . $message . PHP_EOL, FILE_APPEND);
	}


	public function setKeyCaptch($key){
		$this->keyCaptch = $key;
	}

	public function getKeyCaptch(){
		return $this->keyCaptch;
	}

	private function convertDate($dateC){

		if (strlen($dateC) > 10){
        
            list($data, $hora) = explode(' ', $dateC);
        
        } else {
            
            $data = $dateC;

            $hora = '';
        }

        $data = explode('/', $data);

        if (strlen($data[2]) == 2){
            $data[2] = substr(date('Y'), 0, 2) .  $data[2];
        }

        return $data[2] . '-' . $data[1] . '-' . $data[0] . ' ' . $hora;
	}

	public function getData(){
		
		return $this->data;

	}

	public function getErros(){
		
		return $this->error;

	}

	private function formatCNPJ($cnpj){
    	if (!$cnpj)
    		return '';
    	
    	return substr($cnpj, 0, 2) . '.' .  substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
    }

    private function convert($word) {
	    $word = str_replace("@","&#69;",$word);
	    $word = str_replace("`","&#96;",$word);
	    $word = str_replace("¢","%A2",$word);
	    $word = str_replace("£","%A3",$word);
	    $word = str_replace("¥","%A5",$word);
	    $word = str_replace("|","%A6",$word);
	    $word = str_replace("«","%AB",$word);
	    $word = str_replace("¬","%AC",$word);
	    $word = str_replace("¯","%AD",$word);
	    $word = str_replace("º","%B0",$word);
	    $word = str_replace("±","%B1",$word);
	    $word = str_replace("ª","%B2",$word);
	    $word = str_replace("µ","%B5",$word);
	    $word = str_replace("»","%BB",$word);
	    $word = str_replace("¼","%BC",$word);
	    $word = str_replace("½","%BD",$word);
	    $word = str_replace("¿","%BF",$word);
	    $word = str_replace("À","%C0",$word);
	    $word = str_replace("Á","%C1",$word);
	    $word = str_replace("Â","%C2",$word);
	    $word = str_replace("Ã","%C3",$word);
	    $word = str_replace("Ä","%C4",$word);
	    $word = str_replace("Å","%C5",$word);
	    $word = str_replace("Æ","%C6",$word);
	    $word = str_replace("Ç","%C7",$word);
	    $word = str_replace("È","%C8",$word);
	    $word = str_replace("É","%C9",$word);
	    $word = str_replace("Ê","%CA",$word);
	    $word = str_replace("Ë","%CB",$word);
	    $word = str_replace("Ì","%CC",$word);
	    $word = str_replace("Í","%CD",$word);
	    $word = str_replace("Î","%CE",$word);
	    $word = str_replace("Ï","%CF",$word);
	    $word = str_replace("Ð","%D0",$word);
	    $word = str_replace("Ñ","%D1",$word);
	    $word = str_replace("Ò","%D2",$word);
	    $word = str_replace("Ó","%D3",$word);
	    $word = str_replace("Ô","%D4",$word);
	    $word = str_replace("Õ","%D5",$word);
	    $word = str_replace("Ö","%D6",$word);
	    $word = str_replace("Ø","%D8",$word);
	    $word = str_replace("Ù","%D9",$word);
	    $word = str_replace("Ú","%DA",$word);
	    $word = str_replace("Û","%DB",$word);
	    $word = str_replace("Ü","%DC",$word);
	    $word = str_replace("Ý","%DD",$word);
	    $word = str_replace("Þ","%DE",$word);
	    $word = str_replace("ß","%DF",$word);
	    $word = str_replace("à","%E0",$word);
	    $word = str_replace("á","%E1",$word);
	    $word = str_replace("â","%E2",$word);
	    $word = str_replace("ã","%E3",$word);
	    $word = str_replace("ä","%E4",$word);
	    $word = str_replace("å","%E5",$word);
	    $word = str_replace("æ","%E6",$word);
	    $word = str_replace("ç","%E7",$word);
	    $word = str_replace("è","%E8",$word);
	    $word = str_replace("é","%E9",$word);
	    $word = str_replace("ê","%EA",$word);
	    $word = str_replace("ë","%EB",$word);
	    $word = str_replace("ì","%EC",$word);
	    $word = str_replace("í","%ED",$word);
	    $word = str_replace("î","%EE",$word);
	    $word = str_replace("ï","%EF",$word);
	    $word = str_replace("ð","%F0",$word);
	    $word = str_replace("ñ","%F1",$word);
	    $word = str_replace("ò","%F2",$word);
	    $word = str_replace("ó","%F3",$word);
	    $word = str_replace("ô","%F4",$word);
	    $word = str_replace("õ","%F5",$word);
	    $word = str_replace("ö","%F6",$word);
	    $word = str_replace("÷","%F7",$word);
	    $word = str_replace("ø","%F8",$word);
	    $word = str_replace("ù","%F9",$word);
	    $word = str_replace("ú","%FA",$word);
	    $word = str_replace("û","%FB",$word);
	    $word = str_replace("ü","%FC",$word);
	    $word = str_replace("ý","%FD",$word);
	    $word = str_replace("þ","%FE",$word);
	    $word = str_replace("ÿ","%FF",$word);
	    return $word;
	}
}	
