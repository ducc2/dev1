<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * RPC Controller
 * Ohwecoin RPC 통신을 위한 컨트롤러
*/

class RpcController extends Controller
{
    public $method; //RPC Method
    public $params; //RPC Param
    private $account; //User Account
    private $txFee; //fee
    // Configuration options
    private $username; //RPC User Name
    private $password; //RPC User Password
    private $proto; //http : https
    private $host; //Server host
    private $port; //Server port
    private $url; // Server url
    private $cACertificate;
    // Information and debugging
    public $status; //Return status
    public $error; //Return Error
    public $rawResponse; 
    public $response; //Result
    private $id = 0; //RPC Id
    private $user;

     /**
     * @param string $host
     * @param string $url
     */
    public function __construct($host = 'localhost', $url = null)
    {
        $this->host = "";
        $this->username      = ""; //RPC-name
        //$this->password      = "12345"; //RPC-password
        $this->password = "";
        //$this->host          = $host; //RPC-host
        $this->port          = ; //RPC-port
        $this->url           = $url; //RPC-url
        // Set some defaults
        $this->proto         = 'http';
        $this->cACertificate = null;   
        $this->txFee = 0.0001; //Fee
        $this->user = "gpu";
    }
    /**
     * RPC 
     * @return null;
     */
    public function index()
    {   
        $result["address"] = $this->getAccount($this->user);
        $result["balance"] = $this->getBalance($this->user);
        $result["tran"] = $this->getListtransactions($this->user);
        
        
        
        
        return view('rpc/main',$result);
    }
    public function adminSendfrom($from,$to,$amount)
    {
        if( empty($to) ) {
            return false;
            exit;
        }
        if( empty($from) ) {
            return false;
            exit;
        }
        if( empty($amount) ) {
            return false;
            exit;
        }

        $this->method = "sendfrom";
        $this->params = array($from,$to,(float)$amount); //param 설정
        return $this->getCurl();
    }
    /**
     * Get rpc
     * @param 
        GET : $method 
        POST : $req
     * @return json;
    */ 
    public function rpc($method,Request $req)
    {
        $result["err"] = null;
        switch($method) {
            /**
             * Sendfrom
             * @param fromAccount,toAddress,amount
             * @return txhash;
            */ 
            case "sendfrom":
                $this->setTxFee(); //수수료 설정
                $this->method = $method; //method 설정
                $this->params = array($this->user,$req["to"],(float)$req["amount"]); //param 설정
                
                $txHash = $this->getCurl(); //RPC 통신
                if ( !empty($txHash ) ) {
                    $result = $this->getTransaction($txHash);
                    
                }else {
                    $result["err"] = $this->error;
                }
            break;
            default:
            break;
        }
        return response()->json($result);
    }
    /**
     * Get View page
     * @param $views
     * @return null;
    */    
    public function views($views = "send")
    {
        $data = array();
        switch($views){
            case "send" :
                $data["balance"] = $this->getBalance($this->user);
                break;
            case "receive" :
                $data["balance"] = $this->getBalance($this->user);
                $data["address"] = $this->getAccount($this->user);
                $data["tran"] = $this->getListtransactions($this->user);
                
                
                break;
            default:
                $views = "main";
                break;
        }

        return view('rpc/' . $views , $data);
    }
    /**
     * Get new address
     * @param $account 
     * @return address
     */
    private function newAddress($account)
    {
        if( empty($account) ) {
            echo "false";
            exit;
        }
        $this->method = "getaccountaddress";
        $this->params = array($account);
        return $this->getCurl();
    }    
    /**
     * Get Account Address
     * @param $account
     * @return address;
    */
    public function getAccount($account="")
    {
        $this->method = "getaddressesbyaccount";
        $this->params = array($account);
        $address = $this->getCurl();
        //주소가 여러개이면 ..
        is_array($address) ? $cnt =count($address)-1  : $cnt=0;
        //만약 주소가 없다면 ..
        if ( empty($address) ) {
            return false;
        }
        return $address[$cnt];
    }
    /**
     * Get Balance
     * @param $account
     * @return balance;
    */
    public function getBalance($account="")
    {
        $this->method = "getbalance";
        $this->params = array($account,6);
        return $this->getCurl();
    }
    /**
     * Get Listtransactions
     * @param $account
     * @return list;
    */
    public function getListtransactions($account="")
    {
        $this->method = "listtransactions";
        $this->params = array($account);

        $tran = $this->getCurl();

        //Transactions List 거꾸로 정렬
        if( !empty($tran) )
        {
            if (is_array($tran) ) {
                krsort($tran);
            }else {
                $tran = "";
            }
            
        }else {
            $tran = "";
        }
        return $tran;
    }
    /**
     * Get Transaction
     * @param $txHash
     * @return address;
    */
    public function getTransaction($txHash)
    {
        $this->method = "gettransaction";
        $this->params = array($txHash);
        return $this->getCurl();
    }
    /**
     * Set TxFee
     * @param 
     * @return 
    */
    private function setTxFee()
    {
        $this->method = "settxfee";
        $this->params = array( (double) $this->txFee );
        $this->getCurl();
    }

    /**
     * @param string|null $certificate
     */
    public function setSSL($certificate = null)
    {
        $this->proto         = 'https'; // force HTTPS
        $this->cACertificate = $certificate;
    }
    /**
     * Get Curl
     * @param 
     * @return result;
    */
    public function getCurl()
    {   

        //변수 정리
        $this->status       = null;
        $this->error        = null;
        $this->raw_response = null;
        $this->response     = null;
        //Empty Params
        if (!$this->params) {
            $params = array();
        }else{
            $params = array_values($this->params);
        }
        
        $this->id++;
        //Data Set
        $request = json_encode(array(
            'method' => $this->method,
            'params' => $params,
            'id'     => $this->id
        ));
        //Curl
        $curl    = curl_init("{$this->proto}://{$this->host}:{$this->port}/{$this->url}");
        $options = array(
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_USERPWD        => $this->username . ':' . $this->password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_HTTPHEADER     => array('Content-type: application/json'),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $request
        );

        if (ini_get('open_basedir')) {
            unset($options[CURLOPT_FOLLOWLOCATION]);
        }
        if ($this->proto == 'https') {
            if (!empty($this->cACertificate)) {
                $options[CURLOPT_CAINFO] = $this->cACertificate;
                $options[CURLOPT_CAPATH] = DIRNAME($this->cACertificate);
            } else {
                $options[CURLOPT_SSL_VERIFYPEER] = false;
            }
        }
        curl_setopt_array($curl, $options);
        $this->rawResponse = curl_exec($curl);
        $this->response     = json_decode($this->rawResponse, true);
        $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);
        if (!empty($curl_error)) {
            $this->error = $curl_error;
        }
        if ($this->response['error']) {
            //Error Return
            $this->error = $this->response['error']['message'];
        } elseif ($this->status != 200) {
            //Error Return
            switch ($this->status) {
                case 400:
                    $this->error = 'HTTP_BAD_REQUEST';
                    break;
                case 401:
                    $this->error = 'HTTP_UNAUTHORIZED';
                    break;
                case 403:
                    $this->error = 'HTTP_FORBIDDEN';
                    break;
                case 404:
                    $this->error = 'HTTP_NOT_FOUND';
                    break;
            }
        }
        if ($this->error) {
            return $this->error;
        }
        return $this->response['result'];
    }
}