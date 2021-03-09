<?php


namespace App\Helpers;


use GuzzleHttp\Client;

class TrelloApi
{

    private $_baseUrl = 'https://api.trello.com/1/';
    private $_key;
    private $_token;
    private $_boardId;

    public function __construct()
    {
        $this->_key = getenv('TRELLO_KEY');
        $this->_token = getenv('TRELLO_TOKEN');
        $this->_boardId = getenv('TRELLO_BOARD_ID');
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCards()
    {
        $url = "boards/{$this->_boardId}/cards";

        return $this->sendReauest($url);
    }

    /**
     * @param string $urlPart
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendReauest(string $urlPart)
    {
        $url = $this->_baseUrl . $urlPart . "?key={$this->_key}&token={$this->_token}";
        $client = new Client();
        $response = $client->get($url);
        return $response->getBody();
    }


}
