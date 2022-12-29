<?php
require_once "cliente/cliente.class.php";
// Classe de verificação Server-Side
interface iSeguraça
{
  public function clienteTestes(Cliente $Cliente);
}

final class Seguranca implements iSeguraça
{
  private $caracters = [
    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
    'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'á', 'à',
    'â', 'å', 'ã', 'ä', 'æ', 'é', 'ê', 'è', 'ë', 'ð', 'í', 'î', 'ì', 'ï',
    'ó', 'ô', 'ò', 'ø', 'õ', 'ö', 'ú', 'û', 'ù', 'ü', 'ç', 'ñ', 'ý', ' '
  ];

  private $especiais = ['.', '/', ','];
  /**
   * Faz a verificação de nomes
   * 
   * @param string $nome Nome a ser verificado
   * 
   * @return bool Retorn TRUE se o nome estiver correto, FALSE se estiver fora das regras do sistema
   */
  function nome($nome)
  {
    $n_array = str_split(strtolower($nome));
    if ($n_array != false && $nome != '') {
      foreach ($n_array as $value) {
        $contido = in_array($value, $this->caracters);
        if ($contido) {
          return true;
        } else {
          return false;
          break;
        }
      }
    } else {
      return false;
    }
  }

  function texto($nome)
  {
    $n_array = str_split(strtolower($nome));
    if ($n_array != false && $nome != '') {
      foreach ($n_array as $value) {
        $contido = in_array($value, $this->caracters);
        if ($contido || is_numeric($value) == true || in_array($value, $this->especiais)) {
          return true;
        } else {
          return false;
          break;
        }
      }
    } else {
      return false;
    }
  }
  /**
   * Verifica se a Situação do cliente é a esperada
   * 
   * @param string $situação A situação do cliente.
   * 
   * @return bool TRUE se estiver correto, FALSE se for algo que o sistema não espera
   */
  function situacao($situacao)
  {
    $st_list = ['Em dia', 'Em aberto', 'Em débito'];
    if (in_array($situacao, $st_list)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Verifica se o status do cliente está correto
   * 
   * @param string $status O status a serem testados;
   * 
   * @return bool Se correto TRUE, se errado FALSE
   */
  function status($status)
  {
    $status_list = ['Ativo', 'Desativo'];
    if (in_array($status, $status_list)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Checagem se o tipo é o que o sistema espera
   * 
   * @param string $tipo O tipo a ser testado.
   * 
   * @return bool TRUE se estiver correto, FALSE se o valor não for o dentro do esperado.
   */
  function tipo($tipo)
  {
    $tipo_list = ['Comum', 'Mensal'];
    if (in_array($tipo, $tipo_list)) {
      return true;
    } else {
      return false;
    }
  }

  function tipoProduto($tipo){

  }
  /**
   * Todos os teste as serem realizados em um cliente.
   * 
   * @param object $Cliente Objeto cliente com as informações a serem testadas.
   * 
   * @return bool Retorna TRUE se o Cliente estiver com os dados preenchidos de forma correta, FALSE em qualquer outro caso.
   */
  function clienteTestes(Cliente $Cliente)
  {
    $nome = $this->nome($Cliente->getNome());
    $situacao = $this->situacao($Cliente->getSituacao());
    $status = $this->status($Cliente->getStatus());
    $tipo = $this->tipo($Cliente->getTipo());
    if ($nome == true && $situacao == true && $status == true && $tipo == true) {
      return true;
    } else {
      return false;
    }
  }

  function produtoTestes(Produto $Produto){
    $texto = $this->texto($Produto->getNome());
    $texto = $this->texto($Produto->getMarca());
    $texto = $this->texto($Produto->getimagem());
    $texto = $this->texto($Produto->getTipo());
  }

}
