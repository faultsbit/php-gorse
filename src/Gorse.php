<?php

namespace Gorse;

use GuzzleHttp\Exception\GuzzleException;
use  GuzzleHttp;
use Illuminate\Support\Str;

final class Gorse
{
    private string $endpoint;
    private string $apiKey;

    function __construct(string $endpoint, string $apiKey)
    {
        $this->endpoint = $endpoint;
        $this->apiKey   = $apiKey;
    }

    /**
     * @throws GuzzleException
     */
    function insertUser(User $user): RowAffected
    {
        return RowAffected::fromJSON($this->request('POST', '/api/user/', $user));
    }

    /**
     * @param User $user
     * @return RowAffected
     * @throws GuzzleException
     */
    function updateUser(User $user): RowAffected
    {
        return RowAffected::fromJSON($this->request('PATCH', "/api/user/{$user->userId}", ['Labels'=>$user->labels]));
    }

    /**
     * @throws GuzzleException
     */
    function getUser(string $user_id): User
    {
        return User::fromJSON($this->request('GET', '/api/user/' . $user_id, null));
    }

    /**
     * @throws GuzzleException
     */
    function deleteUser(string $user_id): RowAffected
    {
        return RowAffected::fromJSON($this->request('DELETE', '/api/user/' . $user_id, null));
    }

    /**
     * @param Item $item
     * @return RowAffected
     * @throws GuzzleException
     */
    function insertItem(Item $item):RowAffected{
        return RowAffected::fromJSON($this->request('POST','/api/item',$item));
    }

    /**
     * @param Item $item
     * @return RowAffected
     * @throws GuzzleException
     */
    function updateItem(Item $item):RowAffected{
        return RowAffected::fromJSON($this->request('PATCH',"/api/item/{$item->itemId}",$item));
    }

    /**
     * @param string $item_id
     * @return RowAffected
     * @throws GuzzleException
     */
    function deleteItem(string  $item_id):RowAffected{
        return RowAffected::fromJSON($this->request('DELETE',"/api/item/{$item_id}",null));
    }

    /**
     * @throws GuzzleException
     */
    function insertFeedback(array $feedback): RowAffected
    {
        return RowAffected::fromJSON($this->request('POST', '/api/feedback/', $feedback));
    }

    /**
     * @throws GuzzleException
     */
    function getRecommend(RecommendQuery $query): array
    {
        $uri = "/api/recommend/{$query->userId}";
        if ($query->category){
            $uri="{$uri}/{$query->category}";
        }

        return $this->request('GET', $uri, $query->jsonSerialize())??[];
    }

    /**
     * @throws GuzzleException
     */
    private function request(string $method, string $uri, $body)
    {
        $client  = new GuzzleHttp\Client(['base_uri' => $this->endpoint]);
        $options = [GuzzleHttp\RequestOptions::HEADERS => ['X-API-Key' => $this->apiKey]];
        if ($body != null) {
            if (strtoupper($method) != 'GET'){
                $options[GuzzleHttp\RequestOptions::JSON] = $body;
            }else{
                $options[GuzzleHttp\RequestOptions::QUERY] = $body;
            }
        }
        $response = $client->request($method, $uri, $options);
        return json_decode($response->getBody());
    }
}
