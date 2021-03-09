<?php


namespace App\Http\Controllers;


use App\Helpers\TrelloApi;

class CardsController extends \Illuminate\Routing\Controller
{
    private $_types = [
        "Vegetables" => 2,
        "Chicken"    => 2,
        "Fish"       => 1,
        "Meat"       => 1,
        "Desserts"   => 2,
    ];

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getShuffle()
    {
        $cardsToShow = [];
        $trelloClient = new TrelloApi();
        $cards = json_decode($trelloClient->getCards());
        shuffle($cards);

        foreach ($cards as $card) {
            foreach ($card->labels as $label) {
                if (isset($this->_types[$label->name]) && $this->_types[$label->name] > 0) {
                    $cardsToShow[] = $card;
                    $this->_types[$label->name]--;
                }
            }
        }

        return view('randomized', ['cards' => $cardsToShow]);
    }
}
