<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php

use Adianti\Control\TPage;
use Adianti\Widget\Form\TCheckButton;
use Adianti\Widget\Form\TFile;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * MultiStepMultiFormView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Bruno Herculano  
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
//class MultiStepMultiFormView extends TPage
class notebookteste extends TPage
{
    protected $form; // form
    protected $form1; // form

    public static $notebookteste;
    public $xtegdat;
    public $wdat;
    private static $campos;

    use Adianti\Base\AdiantiFileSaveTrait;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        Tpage::include_css('app/resources/formdecorator.css');
        $html = new THtmlRenderer('app/resources/formdecorator.html');
        
        // creates the form

        $this->form = new TForm('notebookteste');

        
        $notebook = new BootstrapNotebookWrapper(new TNotebook(500,200));
        //$notebook = new TNotebook(500,200);
        //$notebook->setTabsDirection('top');
        
        $username = TSession::getValue('userunitname');
        $usernameid = TSession::getValue('userunitid');
        $unitbanx = TSession::getValue('userunitban');
        //new TMessage('info',$unitbanx);
        $label3 = new TLabel('  ');
        $label4 = new TLabel($username);
        $termovtr1 = new TLabel('1. VALE TRANSPORTE EXCEDE A 6% DO SALÁRIO MENSAL, É UM DIREITO DO TRABALHADOR.');
        $termovtr2 = new TLabel('2. BENEFICIÁRIO COMPROMETE-SE A UTILIZAR O VALE TRANSPORTE BASICAMENTE AO EFEITO DO DESLOCAMENTO DA SUA RESIDENCIA AO TRABALHO E VICE VERSA DIARIAMENTE.');
        $termovtr3 = new TLabel('3. DECLARAÇÃO FALSA DO USO INDEVIDO DO BENEFICIO CARACTERIZA RESCISÃO DO CONTRATO DE TRABALHO INDIVIDUAL POR JUSTA CAUSA, ATO DE IMPREBIDADE CONFORME ARTIGO 482 DA CLT.');               
        $termovtr4 = new TLabel('___________________________________________________________________________________________________');
        $termovtr1->setFontstyle('bold');
        $termovtr2->setFontstyle('bold');
        $termovtr3->setFontstyle('bold');
        $termovtr4->setFontstyle('bold');

       
        $painel = new TPanel(700,50);
        $painelvt = new TPanel(700,50);
        $paineltermos = new TPanel(700,50);
        $paineldep = new Tpanel(700,50);
        $title = new TLabel(' ');
        $title->setFontSize(20);
        $title->setFontFace('Arial');
        $title->setFontColor('gray');
        //$title->setFontstyle('u');
        
        $label4->setFontSize(20);
        $label4->setFontFace('Arial');
        $label4->setFontColor('gray');
        //$label4->setFontstyle('u');
        $obrig = new TLabel(' Os campos com (*) são obrigatórios.');
        
        //$painel->put($title, 20,4);  
        $painel->put($label4, 20,4);         
        
        $table = new TTable;
        $table2 = new TTable;
        $table3 = new TTable;
        $table4 = new TTable;    
        $table5 = new TTable; 
        $table6 = new TTable;   
        $table6->addRow();
        $table7 = new TTable;   
        $table8 = new TTable; 
        $table9 = new TTable; 
        $table10 = new TTable;
        $table11 = new TTable;

         
        /*
        $logoonni = new TImage('app/images/onnilogo.png');
        $logoonni->style = 'width: 500px; height: auto;';
        $texto = 'Abertura de Conta Bancária.

        Comunicamos que, a partir do dia 01/05/2022, em virtude da formalização de contrato junto à Instituição Bancária ONNIBANK, que impõe regime de utilização exclusiva, necessitamos abrir conta em nome do colaborador no referido Banco, para fins de pagamento de salário, esclarecendo ainda que isso não ensejará qualquer custo financeiro, pelo que solicitamos sua aceitação, de forma livre e consentida, do tratamento dos dados pessoais estritamente necessários à realização do procedimento de cadastro.';
        
        $link = new TElement('a');
        $link->target = 'newwindow';
        $link->href = 'https://www.onnibank.com.br';
        $link->add('Clique aqui. Para Conhecer mais sobre a Onnibank');

        $textoComQuebras = nl2br($texto);
        $textof = new TLabel($textoComQuebras);
        $textof->setFontstyle('bold');

        
        $table6->addRowSet($logoonni); 
        $table6->addRowSet($textof);
        $table6->addRowSet($link);
        */

        $radio_enable = new TRadioGroup('enable');
        $radio_enable->addItems(array('1'=>'Não possuo conta '.$unitbanx.':', '2'=>'Possuo conta '.$unitbanx.':'));
        $radio_enable->setLayout('vertical');
        $radio_enable->setValue(1);
        $radio_enable->setChangeAction(new TAction([__CLASS__, 'onChangeRadio']));

        $agencia = new TEntry('age');
        $conta = new TEntry('con');
        TEntry::disableField('notebookteste', 'age');
        TEntry::disableField('notebookteste', 'con');

        $table6->addRowSet($radio_enable);
        $table6->addRowSet('Agência',$agencia);
        $table6->addRowSet('Conta com Digito',$conta);
               
        $notebook->appendPage('Dados Cadastrais',$table);
        $notebook->appendPage('Documentação ',$table2);
        $notebook->appendPage('Endereço e Contato ',$table3);
        $notebook->appendPage('Estrangeiro ',$table8);
        $notebook->appendPage('Dependentes',$paineldep);
        //$notebook->appendPage('VT e Fardamento',$table5);
        $notebook->appendPage('Informações Bancárias',$table6);
        
        
        
        
        
        // criação dos campos 
        //$xemp = new TEntry('emp');
        $xemp = new TEntry('emp');
        //if ($username == 'Fortal-015')
        //{
        //   $xemp->setValue('015');
        //}
        
        switch ($usernameid) {
            case '1':
                $xemp->setValue('001');
                break;
            case '2':
                $xemp->setValue('002');
                break;
            case '3':
                $xemp->setValue('003');
                break;
            case '4':
                $xemp->setValue('004');
                break;
            case '5':
                $xemp->setValue('005');
                break;
            case '6':
                $xemp->setValue('006');
                break;
            case '7':
                $xemp->setValue('007');
                break;
        //default:
        }
        
        
        $user_id = TSession::getValue('userid');
        $formatted_id = str_pad($user_id, 5, '0', STR_PAD_LEFT);
        $xmat = new TEntry('mat');
        $xmat->setValue($formatted_id);
        
        $xdes = new TEntry('des');
        $xdes->setProperty('style', 'text-transform:uppercase');
        $xnac = new TCombo('nac');
        $xnas = new TDate('nas');
        $xsex = new TCombo('sex');
        $xmae = new TEntry('mae');
        $xmae->setProperty('style', 'text-transform:uppercase');
        $xgue = new TEntry('gue');
        $xgue->setProperty('style', 'text-transform:uppercase');
        //$xlug = new TCombo('lug');
        $xlug = new TEntry('lug');
        $xlug->setProperty('style', 'text-transform:uppercase');
        $xsit = new TCombo('sit');
        $xrac = new TCombo('rac');
        $xpai = new TEntry('pai');
        $xpai->setProperty('style', 'text-transform:uppercase');
        $xdef = new TCombo('def');
        
        $xcpf = new TEntry('cpf');
        //$xcpf->addValidation('cpf', new TCPFValidator);
        $xcpf->setExitAction(new TAction([$this, 'onValidaCpf']));


        $xide = new TEntry('ide');
        $xrgu = new TCombo('rgu');
        $xctp = new TEntry('ctp');
        $xctu = new TCombo('ctu');
        $xctm = new TEntry('ctm');
        $xcam = new TCombo('cam');
        $xpis = new TEntry('pis');
        $xssp = new TEntry('ssp');
        $xssp->setProperty('style', 'text-transform:uppercase');
        $xdti = new TDate('dti');
        $xser = new TEntry('ser');
        $xcte = new TDate('cte');
        $xins = new TCombo('ins');
        $xele = new TEntry('ele');
        $xzon = new TEntry('zon');
        $xsec = new TEntry('sec');
       

        $xcep = new TEntry('cep');
        $xend = new TEntry('end');
        $xend->setProperty('style', 'text-transform:uppercase');
        $xcpl = new TEntry('cpl');
        $xcpl->setProperty('style', 'text-transform:uppercase');
        $xcid = new TEntry('cid');
        $xcid->setProperty('style', 'text-transform:uppercase');
        $xema = new TEntry('ema');
        $xema->setProperty('style', 'text-transform:uppercase');
        $xbai = new TEntry('bai');
        $xbai->setProperty('style', 'text-transform:uppercase');
        $xnum = new TEntry('num');
        $xesr = new TEntry('esr');
        $xesr->setProperty('style', 'text-transform:uppercase');
        $xtel = new TEntry('tel');
        $xcel = new TEntry('cel');

        $xrvt = new TCombo('rvt');
        $xcan = new TCombo('can');
        $xccn = new TCombo('ccn');
        $xsan = new TCombo('san');



        // dependentes
        $xdepnom = new TEntry('depnom');
        $xdepnom->setProperty('style', 'text-transform:uppercase');
        $xdepcpf = new TEntry('depcpf');
        $xdepcpf->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar = new TCombo('deppar');
        $xdepnas = new TDate('depnas');
        $xdepsex = new TCombo('depsex');
        $xdepinc = new TCombo('depinc');
        $xdepirf = new TCombo('depirf');
        $xdepsaf = new TCombo('depsaf');

        $xdepnom2 = new TEntry('depnom2');
        $xdepnom2->setProperty('style', 'text-transform:uppercase');
        $xdepcpf2 = new TEntry('depcpf2');
        $xdepcpf2->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar2 = new TCombo('deppar2');
        $xdepnas2 = new TDate('depnas2');
        $xdepsex2 = new TCombo('depsex2');
        $xdepinc2 = new TCombo('depinc2');
        $xdepirf2 = new TCombo('depirf2');
        $xdepsaf2 = new TCombo('depsaf2');

        $xdepnom3 = new TEntry('depnom3');
        $xdepnom3->setProperty('style', 'text-transform:uppercase');
        $xdepcpf3 = new TEntry('depcpf3');
        $xdepcpf3->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar3 = new TCombo('deppar3');
        $xdepnas3 = new TDate('depnas3');
        $xdepsex3 = new TCombo('depsex3');
        $xdepinc3 = new TCombo('depinc3');
        $xdepirf3 = new TCombo('depirf3');
        $xdepsaf3 = new TCombo('depsaf3');

        $xdepnom4 = new TEntry('depnom4');
        $xdepnom4->setProperty('style', 'text-transform:uppercase');
        $xdepcpf4 = new TEntry('depcpf4');
        $xdepcpf4->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar4 = new TCombo('deppar4');
        $xdepnas4 = new TDate('depnas4');
        $xdepsex4 = new TCombo('depsex4');
        $xdepinc4 = new TCombo('depinc4');
        $xdepirf4 = new TCombo('depirf4');
        $xdepsaf4 = new TCombo('depsaf4');

        $xdepnom5 = new TEntry('depnom5');
        $xdepnom5->setProperty('style', 'text-transform:uppercase');
        $xdepcpf5 = new TEntry('depcpf5');
        $xdepcpf5->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar5 = new TCombo('deppar5');
        $xdepnas5 = new TDate('depnas5');
        $xdepsex5 = new TCombo('depsex5');
        $xdepinc5 = new TCombo('depinc5');
        $xdepirf5 = new TCombo('depirf5');
        $xdepsaf5 = new TCombo('depsaf5');

        $xcad_dat = new TDate('cad_dat');
        

        
         
                
       //
        //$table->addRowSet('Código da Empresa:', $xemp);
        //$table->addRowSet('Matricula:', $xmat);
        $table->addRowSet('Código da Empresa:', array($xemp,$label3,$label3,'Matricula:', $xmat));//,$label3,$label3,'Data:', $xcad_dat));
        $table->addRowSet('Nome do Tabalhador:*', $xdes);
        $table->addRowSet('Nome Social:', $xgue);
        $table->addRowSet('Nacionalidade:*', $xnac);
        $table->addRowSet('Naturalidade:*', $xlug);
        $table->addRowSet('Data de Nascimento:*', $xnas);
        $table->addRowSet('Gênero:*', $xsex);
        $table->addRowSet('Nome da Mãe:*', $xmae);
        $table->addRowSet('Nome do Pai:', $xpai);
        $table->addRowSet('Estado Civil:*', $xsit);
        $table->addRowSet('Raça ou Cor:*', $xrac);
        $table->addRowSet('Deficiência:*', $xdef);
        $table->addRowSet('Campos(*) são obrigatorios');
        $button0 = new TButton('btn_next', 'Avançar');
        
        //$table->addRowSet($button0);
        //$form1 = new TForm();
        //$form1->add($table);
        //$form1->setFields(array($xemp,$xmat,$xdes,$xgue,$xnac,$xlug,$xnas,$xsex,$xmae,$xpai,$xsit,$xrac,$xdef,$button0));
        //button0->setAction(new TAction(array($this, 'verificarCamposObrigatorios')), 'Verificar e Avançar');


        // Uso da função verificarCamposObrigatorios()

        //if (verificarCamposObrigatorios($minhaTabela)) {
        // Os campos obrigatórios estão preenchidos, você pode prosseguir com a ação desejada
        //    new TMessage('info', 'aqui');
        //}
        
        
        $table2->addRowSet('CPF:*', $xcpf);
        $table2->addRowSet('PIS:',$xpis);
        $table2->addRowSet('RG:*', $xide);
        $table2->addRowSet('Órgão Emissor RG:*', $xssp);
        $table2->addRowSet('UF Emissor RG:*', $xrgu);
        $table2->addRowSet('Data de Emissão RG:*', $xdti);
        $table2->addRowSet('CTPS:', $xctp);
        $table2->addRowSet('Série CTPS:', $xser);
        $table2->addRowSet('UF de Expedição CTPS:', $xctu);
        $table2->addRowSet('Data de Emissão CTPS:', $xcte);
        $table2->addRowSet('CNH:', $xctm);
        $table2->addRowSet('Categoria:',$xcam);
        $table2->addRowSet('Escolaridade*', $xins);
        $table2->addRowSet('Eleitor*', $xele);
        $table2->addRowSet('Zona*', $xzon);
        $table2->addRowSet('Seção*', $xsec);
        $table2->addRowSet('Campos(*) são obrigatorios');

        // Atribui um ID único para o campo CEP
        $xcep->setId('cep');
        $xend->setId('end');
        $xbai->setId('bai');
        $xcid->setId('cid');
        $xesr->setId('xesr');

        
        $script = "
            // Função para preencher os campos de rua, bairro, cidade e estado
            function preencherCampos(endereco) {
                document.getElementById('".$xend->getId()."').value = endereco.logradouro;
                document.getElementById('".$xbai->getId()."').value = endereco.bairro;
                document.getElementById('".$xcid->getId()."').value = endereco.localidade;
                document.getElementById('".$xesr->getId()."').value = endereco.uf;
            }

            // Função para buscar o CEP e preencher os campos
            function buscarCep(cep) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'https://viacep.com.br/ws/' + cep + '/json/', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var endereco = JSON.parse(xhr.responseText);
                        preencherCampos(endereco);
                    }
                };
                xhr.send();
            }

            // Evento de digitação no campo CEP
            document.getElementById('".$xcep->getId()."').addEventListener('keyup', function() {
                var cep = this.value.replace(/\\D/g, '');
                if (cep.length === 8) {
                    buscarCep(cep);
                }
            });
        ";

        // Adiciona o script ao final do HTML gerado
        echo "<script>".$script."</script>";

        $table3->addRowSet('CEP:*',$xcep);
        $table3->addRowSet('Endereço:*', $xend);
        $table3->addRowSet('Número:*', $xnum);
        $table3->addRowSet('Complemento:', $xcpl);
        $table3->addRowSet('Bairro:*', $xbai);
        $table3->addRowSet('Cidade:*', $xcid);
        $table3->addRowSet('Estado:*', $xesr);
        $table3->addRowSet('Email:*', $xema);
        $table3->addRowSet('Celular:*', $xcel);
        $table3->addRowSet('Telefone:', $xtel);
        $table3->addRowSet('Campos(*) são obrigatorios');
        

        $xetg = new TCombo('egt');
        $xetgdat = new TDate('etgdat');
        $xetgnat = new TDate('etgnat');
        $xetgsit = new TEntry('etgsit');
        $xetgfil = new TEntry('etgfil');


        $xetg->addItems(['0' => 'Não','1' => 'Sim' ]);
        $xetg->setDefaultOption(FALSE);
        //$xetg->onChange = new TAction([$this, 'atualizarCampos']);

        $table8->addRowSet();
        
        
        $table8->addRowSet('Estrangeiro:*',$xetg);
        $table8->addRowSet('Data de Chegada:', $xetgdat);
        $table8->addRowSet('Data Naturalização', $xetgnat);
        $table8->addRowSet('Casado(a):', $xetgsit);
        $table8->addRowSet('Filho de Brasileiro(a):', $xetgfil);
        $table8->addRowSet('Campos(*) são obrigatorios');
               

        /*$texto3 = 'TERMO DE DEPENDENTES:
        Declaro que li e estou ciente que devo apresentar à empresa os documentos necessários para obter o benefício do salário família, o qual será pago a partir do mês subsequente da apresentação da aludida documentação. Declaro ainda está ciente de que na ausência da apresentação dos documentos no prazo, o benefício será automaticamente suspenso.
        • Documentos e Prazos; Declaração de frequência escolar a partir de 7 anos (semestralmente); Cartão de Vacina para menores ou igual a 7 anos (anualmente); Certidão de Nascimento.
        Declaro que li e estou ciente que devo apresentar à empresa os documentos necessários para obter o benefício do salário família, o qual será pago a partir do mês subsequente da apresentação da aludida documentação. Declaro ainda está ciente de que na ausência da apresentação dos documentos no prazo, o benefício será automaticamente suspenso.
        
        ';*/
        // _______________________________________________________________________________________________________________________________________________
        
        //$texto3 = nl2br($texto3);
        //$textof3 = new TLabel($texto3);
        //$textof3->setFontstyle('bold');       
        //$table10->addRowSet($textof3);

        // dependentes
        $depescola_file = new TFile('pathdepescola');
        $depescola_file->enableFileHandling();
        $depescola_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola_file->setSize(400);
        $depescola_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf_file = new TFile('pathdepcpf');
        $depcpf_file->enableFileHandling();
        $depcpf_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf_file->setSize(400);
        $depcpf_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina_file = new TFile('pathdepvacina');
        $depvacina_file->enableFileHandling();
        $depvacina_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina_file->setSize(400);
        $depvacina_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas_file = new TFile('pathdepnascas');
        $depnascas_file->enableFileHandling();
        $depnascas_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas_file->setSize(400);
        $depnascas_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg_file = new TFile('pathdeprg');
        $deprg_file->enableFileHandling();
        $deprg_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg_file->setSize(400);
        $deprg_file->setTip('Somente arquivos JPG, JPEG e PDF');

        
        // dependente
        $notebookdep = new BootstrapNotebookWrapper(new TNotebook(900,900));
        //$table->addRowSet('Código da Empresa:', array($xemp,$label3,$label3,'Matricula:', $xmat))
        //$table9->addRowSet('Nome Dependente:',array($xdepnom,$label3,$label3,'Escola:', $depescola_file));
        $table9->addRowSet('Nome Dependente:',$xdepnom);
        $table9->addRowSet('CPF', $xdepcpf);
        $table9->addRowSet('Parentesco', $xdeppar);
        $table9->addRowSet('Data de Nascimento:', $xdepnas);
        $table9->addRowSet('Gênero:', $xdepsex);
        $table9->addRowSet('Incapacitado:', $xdepinc);
        $table9->addRowSet('Dep IRRF:', $xdepirf);
        $table9->addRowSet('Salario Familia:', $xdepsaf);
        $label9 = new TLabel('Anexe os Documentos :');
        $label9->setFontstyle('bold');
        //$table9->addRowSet($label9);

        
        $table9->addRowSet('Escola:', $depescola_file); 
        $table9->addRowSet('CPF:', $depcpf_file);
        $table9->addRowSet('Cartão Vacina:', $depvacina_file); 
        $table9->addRowSet('Certidão Nasc./Casam:', $depnascas_file); 
        $table9->addRowSet('RG:', $deprg_file);    
        $notebookdep->appendpage('Dependente 1', $table9);

        // depe2

        // dependentes
        $depescola2_file = new TFile('pathdepescola2');
        $depescola2_file->enableFileHandling();
        $depescola2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola2_file->setSize(400);
        $depescola2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf2_file = new TFile('pathdepcpf2');
        $depcpf2_file->enableFileHandling();
        $depcpf2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf2_file->setSize(400);
        $depcpf2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina2_file = new TFile('pathdepvacina2');
        $depvacina2_file->enableFileHandling();
        $depvacina2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina2_file->setSize(400);
        $depvacina2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas2_file = new TFile('pathdepnascas2');
        $depnascas2_file->enableFileHandling();
        $depnascas2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas2_file->setSize(400);
        $depnascas2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg2_file = new TFile('pathdeprg2');
        $deprg2_file->enableFileHandling();
        $deprg2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg2_file->setSize(400);
        $deprg2_file->setTip('Somente arquivos JPG, JPEG e PDF');


        $tabledep2 = new TTable();
        $tabledep2->addRowSet('Nome Dependente:',$xdepnom2);
        $tabledep2->addRowSet('CPF', $xdepcpf2);
        $tabledep2->addRowSet('Parentesco', $xdeppar2);
        $tabledep2->addRowSet('Data de Nascimento:', $xdepnas2);
        $tabledep2->addRowSet('Gênero:', $xdepsex2);
        $tabledep2->addRowSet('Incapacitado:', $xdepinc2);
        $tabledep2->addRowSet('Dep IRRF:', $xdepirf2);
        $tabledep2->addRowSet('Salario Familia:', $xdepsaf2);
        $tabledep2->addRowSet('Escola:', $depescola2_file); 
        $tabledep2->addRowSet('CPF:', $depcpf2_file);
        $tabledep2->addRowSet('Cartão Vacina:', $depvacina2_file); 
        $tabledep2->addRowSet('Certidão Nasc./Casam:', $depnascas2_file); 
        $tabledep2->addRowSet('RG:', $deprg2_file);   
        $notebookdep->appendpage('Dependente 2', $tabledep2);

        // dep 3

        // dependentes
        $depescola3_file = new TFile('pathdepescola3');
        $depescola3_file->enableFileHandling();
        $depescola3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola3_file->setSize(400);
        $depescola3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf3_file = new TFile('pathdepcpf3');
        $depcpf3_file->enableFileHandling();
        $depcpf3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf3_file->setSize(400);
        $depcpf3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina3_file = new TFile('pathdepvacina3');
        $depvacina3_file->enableFileHandling();
        $depvacina3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina3_file->setSize(400);
        $depvacina3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas3_file = new TFile('pathdepnascas3');
        $depnascas3_file->enableFileHandling();
        $depnascas3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas3_file->setSize(400);
        $depnascas3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg3_file = new TFile('pathdeprg3');
        $deprg3_file->enableFileHandling();
        $deprg3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg3_file->setSize(400);
        $deprg3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        $tabledep3 = new TTable();
        $tabledep3->addRowSet('Nome Dependente:',$xdepnom3);
        $tabledep3->addRowSet('CPF', $xdepcpf3);
        $tabledep3->addRowSet('Parentesco', $xdeppar3);
        $tabledep3->addRowSet('Data de Nascimento:', $xdepnas3);
        $tabledep3->addRowSet('Gênero:', $xdepsex3);
        $tabledep3->addRowSet('Incapacitado:', $xdepinc3);
        $tabledep3->addRowSet('Dep IRRF:', $xdepirf3);
        $tabledep3->addRowSet('Salario Familia:', $xdepsaf3);
        $tabledep3->addRowSet('Escola:', $depescola3_file); 
        $tabledep3->addRowSet('CPF:', $depcpf3_file);
        $tabledep3->addRowSet('Cartão Vacina:', $depvacina3_file); 
        $tabledep3->addRowSet('Certidão Nasc./Casam:', $depnascas3_file); 
        $tabledep3->addRowSet('RG:', $deprg3_file); 
        $notebookdep->appendpage('Dependente 3', $tabledep3);


        //dep4
        // dependentes
        $depescola4_file = new TFile('pathdepescola4');
        $depescola4_file->enableFileHandling();
        $depescola4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola4_file->setSize(400);
        $depescola4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf4_file = new TFile('pathdepcpf4');
        $depcpf4_file->enableFileHandling();
        $depcpf4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf4_file->setSize(400);
        $depcpf4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina4_file = new TFile('pathdepvacina4');
        $depvacina4_file->enableFileHandling();
        $depvacina4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina4_file->setSize(400);
        $depvacina4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas4_file = new TFile('pathdepnascas4');
        $depnascas4_file->enableFileHandling();
        $depnascas4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas4_file->setSize(400);
        $depnascas4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg4_file = new TFile('pathdeprg4');
        $deprg4_file->enableFileHandling();
        $deprg4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg4_file->setSize(400);
        $deprg4_file->setTip('Somente arquivos JPG, JPEG e PDF');


        $tabledep4 = new TTable();
        $tabledep4->addRowSet('Nome Dependente:',$xdepnom4);
        $tabledep4->addRowSet('CPF', $xdepcpf4);
        $tabledep4->addRowSet('Parentesco', $xdeppar4);
        $tabledep4->addRowSet('Data de Nascimento:', $xdepnas4);
        $tabledep4->addRowSet('Gênero:', $xdepsex4);
        $tabledep4->addRowSet('Incapacitado:', $xdepinc4);
        $tabledep4->addRowSet('Dep IRRF:', $xdepirf4);
        $tabledep4->addRowSet('Salario Familia:', $xdepsaf4);
        $tabledep4->addRowSet('Escola:', $depescola4_file); 
        $tabledep4->addRowSet('CPF:', $depcpf4_file);
        $tabledep4->addRowSet('Cartão Vacina:', $depvacina4_file); 
        $tabledep4->addRowSet('Certidão Nasc./Casam:', $depnascas4_file); 
        $tabledep4->addRowSet('RG:', $deprg4_file); 

        $notebookdep->appendpage('Dependente 4', $tabledep4);


        // dep 5
       // dependentes
        $depescola5_file = new TFile('pathdepescola5');
        $depescola5_file->enableFileHandling();
        $depescola5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola5_file->setSize(400);
        $depescola5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf5_file = new TFile('pathdepcpf5');
        $depcpf5_file->enableFileHandling();
        $depcpf5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf5_file->setSize(400);
        $depcpf5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina5_file = new TFile('pathdepvacina5');
        $depvacina5_file->enableFileHandling();
        $depvacina5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina5_file->setSize(400);
        $depvacina5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas5_file = new TFile('pathdepnascas5');
        $depnascas5_file->enableFileHandling();
        $depnascas5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas5_file->setSize(400);
        $depnascas5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg5_file = new TFile('pathdeprg5');
        $deprg5_file->enableFileHandling();
        $deprg5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg5_file->setSize(400);
        $deprg5_file->setTip('Somente arquivos JPG, JPEG e PDF'); 


        $tabledep5 = new TTable();
        $tabledep5->addRowSet('Nome Dependente:',$xdepnom5);
        $tabledep5->addRowSet('CPF', $xdepcpf5);
        $tabledep5->addRowSet('Parentesco', $xdeppar5);
        $tabledep5->addRowSet('Data de Nascimento:', $xdepnas5);
        $tabledep5->addRowSet('Gênero:', $xdepsex5);
        $tabledep5->addRowSet('Incapacitado:', $xdepinc5);
        $tabledep5->addRowSet('Dep IRRF:', $xdepirf5);
        $tabledep5->addRowSet('Salario Familia:', $xdepsaf5);
        $tabledep5->addRowSet('Escola:', $depescola5_file); 
        $tabledep5->addRowSet('CPF:', $depcpf5_file);
        $tabledep5->addRowSet('Cartão Vacina:', $depvacina5_file); 
        $tabledep5->addRowSet('Certidão Nasc./Casam:', $depnascas5_file); 
        $tabledep5->addRowSet('RG:', $deprg5_file); 
        $notebookdep->appendpage('Dependente 5', $tabledep5);


        
        $paineldep->add($table10);
       // $paineldep->add($table9);
       $paineldep->add($notebookdep);
        
        $table4->addRowSet('Vale Transporte:*', $xrvt);
        $table4->addRowSet('Tamanho Camisa:*', $xcan);
        $table4->addRowSet('Tamanho Calça:*', $xccn);
        $table4->addRowSet('Tamanho Sapato:*', $xsan);
        $table4->addRowSet('Campos(*) são obrigatorios');

        $table5->addRowSet($termovtr1);
        $table5->addRowSet($termovtr2);
        $table5->addRowSet($termovtr3);
        $table5->addRowSet($termovtr4);
        
        $painelvt->add($table5);
        $painelvt->add($table4);
        $notebook->appendPage('VT e Fardamento',$painelvt);

        //termos
        $textolgpd = 'TERMO LGPD:       
        Declaro, para os devidos fins, que concordo com a coleta dos meus dados pessoais para fim de conformidade com a Lei 13.709/2018 - Lei Geral de Proteção de dados, com manifestação livre, informada e inequívoca de vontade, de acordo com os termos de uso.
        
        TERMO DO NEPOTISMO:
        Declaro, para os devidos fins, que as informações proferidas na declaração de Nepotismo são verdadeiras, não havendo qualquer grau de parentesco com servidor público em atividade, e foram fornecidas com manifestação livre, informada e inequívoca de vontade, de acordo com os termos de uso.';

        $texto2 = '
        Declaro para os devidos fins que as informações constantes neste formulário são fieis à verdade e condizentes com a realidade dos fatos à epoca.
        Declaro que todas as informações mencionadas nesse formulário foram extraídas dos documentos e são de minha responsabilidade.
        Por fim, fico ciente que através desse documento a falsidade das informações configura crime previsto no Código Penal Brasileiro e passível de apuração na forma da Lei.
        Nada mais a declarar, e ciente das responsabilidades peças declarações prestadas, firmo a presente.
        ';

        $textolgpd        = new TText('text');
        
        // add the fields inside the form
        //$this->form->addFields(['Text'], [$text] );
        
        $textolgpd->setSize(800,300);
        $textolgpd->setvalue("
TERMO DE DEPENDENTES:

Declaro que li e estou ciente que devo apresentar à empresa os documentos necessários para obter o benefício do salário família, o qual será pago a partir do mês subsequente da apresentação da aludida documentação. Declaro ainda está ciente de que na ausência da apresentação dos documentos no prazo, o benefício será automaticamente suspenso.

• Documentos e Prazos; Declaração de frequência escolar a partir de 7 anos (semestralmente); Cartão de Vacina para menores ou igual a 7 anos (anualmente); Certidão de Nascimento.

Declaro que li e estou ciente que devo apresentar à empresa os documentos necessários para obter o benefício do salário família, o qual será pago a partir do mês subsequente da apresentação da aludida documentação. Declaro ainda está ciente de que na ausência da apresentação dos documentos no prazo, o benefício será automaticamente suspenso.


TERMO LGPD:       
Declaro, para os devidos fins, que concordo com a coleta dos meus dados pessoais para fim de conformidade com a Lei 13.709/2018 - Lei Geral de Proteção de dados, com manifestação livre, informada e inequívoca de vontade, de acordo com os termos de uso.

TERMO DO NEPOTISMO:
Declaro, para os devidos fins, que as informações proferidas na declaração de Nepotismo são verdadeiras, não havendo qualquer grau de parentesco com servidor público em atividade, e foram fornecidas com manifestação livre, informada e inequívoca de vontade, de acordo com os termos de uso.

Declaro para os devidos fins que as informações constantes neste formulário são fieis à verdade e condizentes com a realidade dos fatos à epoca.

Declaro que todas as informações mencionadas nesse formulário foram extraídas dos documentos e são de minha responsabilidade.

Por fim, fico ciente que através desse documento a falsidade das informações configura crime previsto no Código Penal Brasileiro e passível de apuração na forma da Lei.

Nada mais a declarar, e ciente das responsabilidades peças declarações prestadas, firmo a presente.
        
        ");


        
        //$textolgpd = nl2br($textolgpd);
        $textof5 = new TLabel($textolgpd);
       

        /*$texto2 = nl2br($texto2);
        $textof2 = new TLabel($texto2);
        $textof2->setFontstyle('bold');*/

        $aceite = new TCheckButton('aceite');
        $taceite = 'Aceite os termos para continuar';
        //$texto3->setFontstyle('bold');
        //$table7->addRowSet($textof3);
        $table7->addRowSet(new TLabel(' '));
        $table7->addRowSet(new TLabel('Leia atentamente os termos:'));
        $table7->addRowSet($textof5);
        //$table7->addRowSet( [$aceite], [new TLabel('TCheckButton (switch):')]);
        
        //$table7->addRowSet($textof2);
        //$this->form->addFields( [new TLabel('TCheckButton (switch):')], [$check3] );

        $painelaceite = new TPanel(300,1);
        $painelaceite->put($aceite,0,50);
        $painelaceite->put($taceite,20,50);
        $table7->addRowSet($painelaceite);

        //$paineltermos->add($table7);
        //$paineltermos->add($painelaceite);
        //$notebook->appendPage('Termos',$paineltermos);
        $notebook->appendPage('Termos',$table7);

        $table11->addRowset();

        // RG
        $rg_file = new TFile('pathrg');
        $rg_file->enableFileHandling();
        $rg_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $rg_file->setSize(300);
        $rg_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // CPF
        $cpf_file = new TFile('pathcpf');
        $cpf_file->enableFileHandling();
        $cpf_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $cpf_file->setSize(300);
        $cpf_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // Comprovante de Residência
        $res_file = new TFile('pathresidencia');
        $res_file->enableFileHandling();
        $res_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $res_file->setSize(300);
        $res_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // ELEITOR
        $eleitor_file = new TFile('patheleitor');
        $eleitor_file->enableFileHandling();
        $eleitor_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $eleitor_file->setSize(300);
        $eleitor_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // RESERVISTA
        $reserva_file = new TFile('pathreserva');
        $reserva_file->enableFileHandling();
        $reserva_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $reserva_file->setSize(300);
        $reserva_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // pis
        $pis_file = new TFile('pathpis');
        $pis_file->enableFileHandling();
        $pis_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $pis_file->setSize(300);
        $pis_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // vacina
        $vacina_file = new TFile('pathvacina');
        $vacina_file->enableFileHandling();
        $vacina_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $vacina_file->setSize(300);
        $vacina_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // nascimento ou casamento
        $nascas_file = new TFile('pathnascas');
        $nascas_file->enableFileHandling();
        $nascas_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $nascas_file->setSize(300);
        $nascas_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // escolaridade
        $escola_file = new TFile('pathescola');
        $escola_file->enableFileHandling();
        $escola_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $escola_file->setSize(300);
        $escola_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // ctps
        $ctps_file = new TFile('pathctps');
        $ctps_file->enableFileHandling();
        $ctps_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $ctps_file->setSize(300);
        $ctps_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // curriculo
        $curriculo_file = new TFile('pathcurriculo');
        $curriculo_file->enableFileHandling();
        $curriculo_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $curriculo_file->setSize(300);
        $curriculo_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // Fotos
        $foto_file = new TFile('pathfoto');
        $foto_file->enableFileHandling();
        $foto_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $foto_file->setSize(300);
        $foto_file->setTip('Somente arquivos JPG, JPEG e PDF');

        

        $table11->addRowSet('RG:*', $rg_file);
        $table11->addRowSet('CPF:*', $cpf_file);
        $table11->addRowSet('Comprovante de residencia com CEP:*', $res_file);
        $table11->addRowSet('Titulo de Eleitor:*', $eleitor_file);
        $table11->addRowSet('Reservista (homens):*', $reserva_file);
        $table11->addRowSet('Extrato do PIS:*', $pis_file);
        $table11->addRowSet('Cartão de Vacina:*', $vacina_file);
        $table11->addRowSet('Cert. de Nascimento ou Casamento:*', $nascas_file);
        $table11->addRowSet('Comprovante de Escolaridade:*', $escola_file);
        $table11->addRowSet('Cópia da CTPS Digital:*', $ctps_file);
        $table11->addRowSet('Curriculo:*', $curriculo_file);
        $table11->addRowSet('Foto:*', $foto_file);

        $notebook->appendPage('Anexos',$table11);

        
        $xchncategoria = ['A','B','A/B','C','D','E'];

        $racacor = [ 'Branco', 'Negro','Pardo', 'Amarelo','Indígena','Outra' ];

        //$xgrau = ['Ensino Fundamental','Ensino Médio','Ensino Técnico','Graduação','Pós-Graduação','Mestrado','Doutorado'];
        $xgrau = ['','Analfabeto','Até a 5°S. Imcompleto','5° Série Completa','De 5° ao 8° Imcomp','1° Grau Completo','Médio Incompleto','Médio Completo',
                  'Superior Incompleto','Superior Completo','Pós-Graduação','Mestrado','Doutorado'];

        $xsim = ['Sim','Não'];

        $xufcombo = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA',
                     'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

        $xsexcombo = [ 'M'=>'Masculino','F'=>'Feminino','N'=>'Não Informar'];

        $xparent = [ 'Filho','Cônjuge','Outros'];

        $xnacionalidade = [
            '10'=>'BRASILEIRO',
            '20'=>'NATURALIZADO / BRASILEIRO',
            '21'=>'ARGENTINO',
            '22'=>'BOLIVIANO',
            '23'=>'CHILENO',
            '24'=>'PARAGUAIO',
            '25'=>'URUGUAIO',
            '26'=>'DOMINICANO',
           // 'MEXICANO',
            //'PERUANO',
            //'EQUATORIANO',
            '30'=>'ALEMÃO',
            '31'=>'BELGA',
            '32'=>'BRITÂNICO',
            '34'=>'CANADENSE',
            '35'=>'ESPANHOL',
            '36'=>'NORTE-AMERICANO (EUA)',
            '37'=>'FRANCÊS',
            '38'=>'SUÍÇO',
            '39'=>'ITALIANO',
            //'HAITIANO',
            '41'=>'JAPONÊS',
            '42'=>'CHINÊS',
            '43'=>'COREANO',
            //'RUSSO',
            '45'=>'PORTUGUÊS',
            //'PAQUISTANÊS',
            //'INDIANO',
            '48'=>'OUTROS LATINO-AMERICANOS',
            '49'=>'OUTROS ASIÁTICOS',
            '50'=>'OUTROS',

        ];

        $xnaturalidade = [     
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins'

        ];

        $fardacamisa = [
            'PP'=>'PP',
            'P'=>'P',
            'M'=>'M',
            'G'=>'G',
            'GG'=>'GG',
            'XGG'=>'XGG'
        ];
        $fardacalca = [
            '36' => '36',
            '38' => '38',
            '40' => '40',
            '42' => '42',
            '44' => '44',
            '46' => '46',
            '48' => '48',
            '50' => '50',
            '52' => '52'
        ];
        $fardasapato = [
            '36' => '36',
            '37' => '37', 
            '38' => '38',
            '39' => '39', 
            '40' => '40',
            '41' => '41', 
            '42' => '42',
            '43' => '43', 
            '44' => '44',
            '45' => '45', 
            '46' => '46'
        ];


        // Aplicando características dos campos
        
        $xemp->setEditable(FALSE);
        $xemp->setSize(50);
        $xmat->setEditable(FALSE);
        $xmat->setSize(70);
        $xdes->setSize(100);
        //$xdes->setMaxLength(40);
        $xdes->setSize(500);
        //$xufcombo->setSize(50);
        $xgue->setMaxLength(40);
        $xgue->setSize(500);
        $xrac->addItems($racacor);
        $xnac->addItems($xnacionalidade);
        //$xlug->addItems($xnaturalidade);
        $xlug->placeholder= "exemplo: FORTALEZA";

        $xrgu->addItems($xufcombo);
        $xcam->addItems($xchncategoria);
        $xrgu->setSize(80);
        $xcam->setSize(100);
        //$xesr->addItems($xufcombo);
        $xesr->setSize(80);

        $xctu->addItems($xufcombo);
        $xctu->setSize(80);



        $xcte->setMask('dd/mm/yyyy');
        $xnas->setMask('dd/mm/yyyy');
        $xdti->setMask('dd/mm/yyyy');
        $xetgdat->setMask('dd/mm/yyyy');
        $xetgnat->setMask('dd/mm/yyyy');
        $xdepnas->setMask('dd/mm/yyyy');
        $xdepnas2->setMask('dd/mm/yyyy');
        $xdepnas3->setMask('dd/mm/yyyy');
        $xdepnas4->setMask('dd/mm/yyyy');
        $xdepnas5->setMask('dd/mm/yyyy');

        $xsex->addItems($xsexcombo);
        $xsex->setSize(150);     
        $xsit->addItems(array(1=>'Solteiro', 2=>'Casado', 3=>'Separado', 4=>'Separado', 5=>'Viúvo'));
        $xsit->setSize(150);
        $xdef->addItems(array(1=>'Sem deficiência', 2=>'Física', 3=>'Visual', 4=>'Auditiva', 5=>'Intelectual', 6=>'Validação'));
        
        $xins->addItems($xgrau);
        $xdef->setSize(150);
        $xmae->setMaxLength(40);

        $xmae->setSize(500);
        $xpai->setMaxLength(40);
        $xpai->setSize(500);
        $xssp->setSize(100);
        $xcep->setSize(100);
        $xcep->setMask('99.999-999');
        //$xpis->setMask('999.99999.99-9');
        $xcep->placeholder= "99.999-999";
        $xend->setSize(500);
        $xnum->setSize(70);
        $xbai->setSize(500);
        $xcid->setSize(500);
        $xesr->setSize(50);
        $xema->placeholder= "exemplo@gmail.com";
        $xcel->placeholder= "(99)99999-9999";
        $xcel->setMask('(99)99999-9999');
        $xtel->placeholder= "(99)9999-9999";
        $xtel->setMask('(99)9999-9999');
        $xcpl->setSize(300);
        
        $xcpf->setMask('999.999.999-99');
        $xcpf->placeholder= "999.999.999-99";
        $xdes->placeholder= "Preencha seu nome";
        $xgue->placeholder= "Preencha seu nome (Opcional)";
        //$xdti->setSize(100);
        $xcte->setSize(100);
        $xide->setMaxLength(13);

        $xrvt->addItems(array(1=>'Sim', 2=>'Não'));
        $xrvt->setSize(100);
        $xcan->setSize(100);
        $xccn->setSize(100);
        $xsan->setSize(100);
        $xcam->setSize(100);

        //estrangeiros
        /*
        $xetg->addItems($xsim);
        $xetg->setSize(60);
        $xetgsit->addItems($xsim);
        $xetgsit->setSize(60);
        $xetgfil->addItems($xsim);
        $xetgfil->setSize(60);
        */

        //dependentes
        $xdepnom->setSize(500);
        $xdeppar->addItems($xparent);
        $xdeppar->setSize(100);
        $xdepsex->addItems($xsexcombo);
        $xdepsex->setSize(100);
        $xdepcpf->setMask('999.999.999-99');
        $xdepcpf->placeholder= "999.999.999-99";

        $xdepinc->addItems($xsim);
        $xdepirf->addItems($xsim);
        $xdepsaf->addItems($xsim);
        $xdepinc->setSize(100);
        $xdepirf->setSize(100);
        $xdepsaf->setSize(100);
       
        $xdepnom2->setSize(500);
        $xdeppar2->addItems($xparent);
        $xdeppar2->setSize(100);
        $xdepsex2->addItems($xsexcombo);
        $xdepsex2->setSize(100);
        $xdepcpf2->setMask('999.999.999-99');
        $xdepcpf2->placeholder= "999.999.999-99";
        $xdepinc2->addItems($xsim);
        $xdepirf2->addItems($xsim);
        $xdepsaf2->addItems($xsim);
        $xdepinc2->setSize(100);
        $xdepirf2->setSize(100);
        $xdepsaf2->setSize(100);

        $xdepnom3->setSize(500);
        $xdeppar3->addItems($xparent);
        $xdeppar3->setSize(100);
        $xdepsex3->addItems($xsexcombo);
        $xdepsex3->setSize(100);
        $xdepcpf3->setMask('999.999.999-99');
        $xdepcpf3->placeholder= "999.999.999-99";
        $xdepinc3->addItems($xsim);
        $xdepirf3->addItems($xsim);
        $xdepsaf3->addItems($xsim);
        $xdepinc3->setSize(100);
        $xdepirf3->setSize(100);
        $xdepsaf3->setSize(100);

        $xdepnom4->setSize(500);
        $xdeppar4->addItems($xparent);
        $xdeppar4->setSize(100);
        $xdepsex4->addItems($xsexcombo);
        $xdepsex4->setSize(100);
        $xdepcpf4->setMask('999.999.999-99');
        $xdepcpf4->placeholder= "999.999.999-99";
        $xdepinc4->addItems($xsim);
        $xdepirf4->addItems($xsim);
        $xdepsaf4->addItems($xsim);
        $xdepinc4->setSize(100);
        $xdepirf4->setSize(100);
        $xdepsaf4->setSize(100);

        $xdepnom5->setSize(500);
        $xdeppar5->addItems($xparent);
        $xdeppar5->setSize(100);
        $xdepsex5->addItems($xsexcombo);
        $xdepsex5->setSize(100);
        $xdepcpf5->setMask('999.999.999-99');
        $xdepcpf5->placeholder= "999.999.999-99";
        $xdepinc5->addItems($xsim);
        $xdepirf5->addItems($xsim);
        $xdepsaf5->addItems($xsim);
        $xdepinc5->setSize(100);
        $xdepirf5->setSize(100);
        $xdepsaf5->setSize(100);
        //fardamentos

        $xcan->addItems($fardacamisa);
        $xccn->addItems($fardacalca);
        $xsan->addItems($fardasapato);
 
                
        $bava = TButton::create('save', array($this,'onSave'),'Salvar','fa:save');
        $replace = array('bava'=>$bava);
        $html->enableSection('main', $replace);
        
        $notebook->appendPage('Finalizar',$html);

        
        // adiionando os campos da table no form
        $this->form->setFields(array($xemp,$xmat,$xdes,$xgue,$xnac,$xnas,$xsex,$xmae,$xlug,$xsit,$xrac,
                                     $xpai,$xcpf,$xide,$xctp,$xctu,$xctm,$xpis,$xssp,$xdti,$xser,$xdef,
                                     $xcte,$xins,$xcep,$xend,$xcpl,$xcid,$xema,$xbai,$xnum,$xesr,$xtel,
                                     $xrgu,$xcel,$xrvt,$xcan,$xccn,$xsan,$xetg,$xele,$xsec,$xzon,
                                     $xdepnom,$xdepcpf,$xdeppar,$xdepnas,$xdepsex,$xdepinc,$xcam,
                                     $xdepnom2, $xdepcpf2, $xdeppar2, $xdepnas2, $xdepsex2, $xdepinc2,
                                     $xdepnom3, $xdepcpf3, $xdeppar3, $xdepnas3, $xdepsex3, $xdepinc3,
                                     $xdepnom4, $xdepcpf4, $xdeppar4, $xdepnas4, $xdepsex4, $xdepinc4,
                                     $xdepnom5, $xdepcpf5, $xdeppar5, $xdepnas5, $xdepsex5, $xdepinc5,                                     
                                     $bava,$button0,$xcad_dat,$rg_file,$cpf_file,$res_file,$radio_enable,
                                     $agencia,$conta,$eleitor_file,$reserva_file,$pis_file,$vacina_file,
                                     $nascas_file,$escola_file,$ctps_file,$curriculo_file,$foto_file,
                                     $depcpf_file,$depescola_file,$deprg_file,$depnascas_file,$depvacina_file,
                                     $depcpf2_file,$depescola2_file,$deprg2_file,$depnascas2_file,$depvacina2_file,
                                     $depcpf3_file,$depescola3_file,$deprg3_file,$depnascas3_file,$depvacina3_file,
                                     $depcpf4_file,$depescola4_file,$deprg4_file,$depnascas4_file,$depvacina4_file,
                                     $depcpf5_file,$depescola5_file,$deprg5_file,$depnascas5_file,$depvacina5_file,
                                     $xdepirf,$xdepsaf,$xdepirf2,$xdepsaf2,$xdepirf3,$xdepsaf3,$xdepirf4,$xdepsaf4,
                                     $xdepirf5,$xdepsaf5));
                                     // ,$xetgdat,$xetgnat,$xetgsit,$xetgfil,
        
        //$notebook->setTabAction(new TAction(array($this, 'doActionOnAba2')));
            
            
        //$notebook->add($bava);
        //$this->form->add($unidade);
        $this->form->add($painel);
        $this->form->add($notebook);
        //$this->form->add($bava);
    
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';        
        
        $vbox->add($this->form);

        parent::add($vbox);
    }

    public static function onValidaCpf($param)
    {
        try {
            $validator = new TCPFValidator;
            $validator->validate('CPF', $param['cpf']);
            //new TMessage('info', 'CPF Válido');
        } catch (Exception $e) {        
            //new TMessage('info', $e);
            //new TMessage('info', 'CPF xxxxxxxválido!');
        }
        /*
        if (notebookteste::isValid($param['cpf'])) {
            new TMessage('info', '✅ CPF válido!');
        } else {
            new TMessage('error', '❌ CPF inválido!');
        }*/
    }

    public static function isValid($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }


     // Chamada quando mudar o radio
    public static function onChangeRadio($param)
    {
        if ($param['enable'] == '2') {
            /*foreach (self::$campos as $campo) {
                TEntry::enableField('notebookteste', $campo->getName());
            }*/
            TEntry::enableField('notebookteste', 'age');
            TEntry::enableField('notebookteste', 'con');
        } else {
            /*foreach (self::$campos as $campo) {
                TEntry::disableField('notebookteste', $campo->getName());
            }*/
            TEntry::disableField('notebookteste', 'age');
            TEntry::disableField('notebookteste', 'con');
        }
    }

    function verificarCamposObrigatorios()
    {
        $field1Value = $_POST['des'];

        if (empty($field1Value)) {
            new TMessage('error', 'Campo 1 está vazio!');
        } else {
            new TMessage('info', 'Campo 1 não está vazio!');
        }
    }
    
 
    public function onSave($param)
    {
        try
        {   
            //////////////////////
        /*
            try {
                 $type = 'html';
                 Mailservice::send(['herculanobruno01@gmail.com'],'teste','hello mail');

                 new TMessage('info','Email enviado com sucesso!');
                
            } catch (Exception $e) {
                echo 'Erro ao enviar o e-mail: ' . $e->getMessage();
            }
            //////////////////////
            */
            
            TTransaction::open('teste');
            $this->form->validate();

            $data = $this->form->getData();
            $this->form->setData($data);
            
            $object = new Sipfun;
            $object->fromArray ((array)$data);

            ////////////////////////////////////

            /*
            $upload_path = 'files/documents/';

            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            // Move os arquivos (se existirem)
            if (!empty($data->pathrg)) {
               
                $data->pathrg = TFile::moveUploadedFile($data->pathrg, $upload_path);

            }

            if (!empty($data->pathcpf)) {
                $data->pathcpf = TFile::moveUploadedFile($data->pathcpf, $upload_path);
            }

            if (!empty($data->pathresidencia)) {
                $data->pathresidencia = TFile::moveUploadedFile($data->pathresidencia, $upload_path);
            }
*/
            

            ///////////////////////////////////////////////////
            /*
            switch ($data->cpf ){
               case '999.999.999-99':
                     //new TMessage('info','CPF inválido')
                     throw new Exception('CPF inválido: '. $data->cpf );
               case '111.111.111-11':
                    throw new Exception('CPF inválido: '. $data->cpf );
               case '222.222.222-22':
                    throw new Exception('CPF inválido: '. $data->cpf );
               case '333.333.333-33':
                    throw new Exception('CPF inválido: '. $data->cpf );
               case '444.444.444-44':
                     throw new Exception('CPF inválido: '. $data->cpf );
               case '555.555.555-55':
                     throw new Exception('CPF inválido: '. $data->cpf );
               case '666.666.666-66':
                     throw new Exception('CPF inválido: '. $data->cpf );
               case '777.777.777-77':
                     throw new Exception('CPF inválido: '. $data->cpf );
               case '888.888.888-88':
                     throw new Exception('CPF inválido: '. $data->cpf );
               case '999.999.999-99':
                     throw new Exception('CPF inválido:'. $data->cpf );
               case '000.000.000-00':
                     throw new Exception('CPF inválido: '. $data->cpf );
               case '123.456.789.99':
                     throw new Exception('CPF inválido: '. $data->cpf );
                     
            }
            $valcpf = filter_input(INPUT_POST, 'cpf'); // Obtenha o valor do campo CPF do formulário

            // Remover caracteres não numéricos
            $valcpf = preg_replace('/[^0-9]/', '', $valcpf);

            // Verificar se o CPF tem 11 dígitos
            if (strlen($valcpf) !== 11) {
                //throw new Exception('CPF inválido',$data->cpf);
                throw new Exception('CPF inválido: ' . $valcpf . ' deve conter 11 dígitos!');
               
            }
            */
            /*
            if (empty($data->des))
            {
                throw new Exception('Preencha seu Nome');
            }
            if (($data->nac === 0))
            {
                throw new Exception('Preencha sua Nacionalidade');
            }
            if (($data->lug===0))
            {
                throw new Exception('Preencha sua Naturalidade');
            }
            if (empty($data->nas))
            {
                throw new Exception('Preencha sua Data de Nascimento');
            }
            if (($data->sex===0))
            {
                throw new Exception('Preencha seu Gênero');
            }
            if (empty($data->mae))
            {
                throw new Exception('Preencha o nome da sua Mãe');
            }
            
            if (empty($data->pai))
            {
                throw new Exception('Preencha o nome do seu Pai');
            }
            
            if (empty($data->sit))
            {
                throw new Exception('Preencha seu Estado Civil');
            }
            if (($data->rac===0))
            {
                throw new Exception('Preencha sua Raça');
            }
            if (($data->def===0))
            {
                throw new Exception('Preencha o campo de deficiência');
            }
            // SEGUNDA ABA
            if (empty($data->cpf))
            {
                throw new Exception('Preencha seu CPF');
            }

            

            if (empty($data->pis))
            {
                throw new Exception('Preencha seu Pis');
            }
            if (empty($data->ide))
            {
                throw new Exception('Preencha seu RG');
            }

            if (empty($data->ssp))
            {
                throw new Exception('Preencha o órgão Emissor do RG');
            }
            if (empty($data->dti))
            {
                throw new Exception('Preencha a data de Emissão do RG');
            }
            if (empty($data->ctp))
            {
                throw new Exception('Preencha o numero da CTPS');
            }
            if (empty($data->ser))
            {
                throw new Exception('Preencha a serie da CTPS');
            }
            if (empty($data->ctu))
            {
                throw new Exception('Preencha a UF da CTPS');
            }
            if (($data->cte===0))
            {
                throw new Exception('Preencha a data dde emissao da CTPS');
            }
            if (($data->ins===0))
            {
                throw new Exception('Preencha a Escolaridade');
            }

            // TERCEIRA ABA
            if (empty($data->cep))
            {
                throw new Exception('Preencha seu CEP');
            }

            if (empty($data->end))
            {
                throw new Exception('Preencha o endereço');
            }
            if (empty($data-> num))
            {
                throw new Exception('Preencha o numero da sua residência');
            }
            if (empty($data->bai))
            {
                throw new Exception('Preencha seu bairro');
            }
            if (empty($data->cid))
            {
                throw new Exception('Preencha sua cidade');
            }
            if (empty($data->esr))
            {
                throw new Exception('Preencha seu Estado');
            }
            if (empty($data->ema))
            {
                throw new Exception('Preencha seu Email');
            }
            if (empty($data->cel))
            {
                throw new Exception('Preencha seu Celular');
            }

            //Quarta aba
            /*
            if (($data->etg===0))
            {
                throw new Exception('Preencha o campo de estrangeiro (Responda Não caso não seja)');
            }
            

            // setima aba
            if (($data->rvt===0))
            {
                throw new Exception('Preencha o campo de vale transporte');
            }
            if (($data->can===0))
            {
                throw new Exception('Preencha o tamanho da sua camisa');
            }
            if (($data->ccn===0))
            {
                throw new Exception('Preencha o tamanho da sua calça');
            }
            if (($data->san===0))
            {
                throw new Exception('Preencha o tamanho do seu sapato');
            }
            */
            $wdat = date('Y-m-d');
            $object->cat_dat = $wdat;
            
            // transformando a data US p/ BR
            $object->nas     = TDate::date2us($object->nas);
            $object->cte     = TDate::date2us($object->cte);
            $object->dti     = TDate::date2us($object->dti);
            $object->etgdat  = TDate::date2us($object->etgdat);
            $object->etgnat  = TDate::date2us($object->etgnat);
            $object->depnas  = TDate::date2us($object->depnas);
            $object->depnas2 = TDate::date2us($object->depnas2);
            $object->depnas3 = TDate::date2us($object->depnas3);
            $object->depnas4 = TDate::date2us($object->depnas4);
            $object->depnas5 = TDate::date2us($object->depnas5);

            // transformando em maiuscula
            $object->end     = strtoupper($object->end);
            $object->cpl     = strtoupper($object->cpl);
            $object->cid     = strtoupper($object->cid);
            $object->ema     = strtoupper($object->ema);
            $object->bai     = strtoupper($object->bai);
            $object->esr     = strtoupper($object->esr);
            $object->mae     = strtoupper($object->mae);
            $object->pai     = strtoupper($object->pai);
            $object->ssp     = strtoupper($object->ssp);
            $object->gue     = strtoupper($object->gue);
            $object->des     = strtoupper($object->des);
            $object->lug     = strtoupper($object->lug);
            $object->depnom  = strtoupper($object->depnom);
            $object->depnom2 = strtoupper($object->depnom2);
            $object->depnom3 = strtoupper($object->depnom3);
            $object->depnom4 = strtoupper($object->depnom4);
            $object->depnom5 = strtoupper($object->depnom5);



            $object->store();
            //$wdat->store();
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathrg',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathcpf',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathresidencia',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'patheleitor',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathreserva',$warq);
            
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathpis',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathvacina',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathnascas',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathescola',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathctps',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathcurriculo',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathfoto',$warq);

            // DEPENDENTES
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg',$warq);
            // dep2
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg2',$warq);
            // dep3
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg3',$warq);
            // dep4
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg4',$warq);
            
            // dep5
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg5',$warq);


            /*$this->saveFile($object, $data, 'pathcpf','files/documents/cpf');
            $this->saveFile($object, $data, 'pathresidencia','files/documents');*/
            new TMessage('info', 'Operação realizada com sucesso, aguarde o contato da empresa .');
            //new TMessage('info', str_replace(',','<br>', json_encode($data)));
            // Load another page
            TTransaction::close();
            //AdiantiCoreApplication::loadPage('SipfunForm2', 'onLoadFromForm1', (array) $data);
            
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}
