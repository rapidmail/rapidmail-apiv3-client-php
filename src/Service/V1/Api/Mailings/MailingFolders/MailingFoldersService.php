<?php

declare(strict_types=1);

namespace Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingFolders;

use GuzzleHttp\RequestOptions;
use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Service\AbstractService;
use Rapidmail\ApiClient\Service\Response\HalResponse;
use stdClass;

class MailingFoldersService extends AbstractService
{
    /**
     * @inheritDoc
     */
    protected function getResourcePath()
    {
        return 'mailings';
    }

    /**
     * Fetch all mailing folders as array
     *
     * @return array
     * @throws ApiException
     */
    public function fetchAll()
    {

        $response = $this->client->request(
            'GET',
            "{$this->getResourcePath()}/folders"
        );

        $decodedResponse = json_decode($response->getBody()->getContents());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException(json_last_error_msg());
        }

        if (empty($decodedResponse) || !property_exists($decodedResponse, 'folders')) {
            $decodedResponse = [];
        }

        return $decodedResponse->folders;
    }

    /**
     * Create a new folder
     *
     * @param string $folderName
     * @return stdClass
     * @throws ApiException
     */
    public function create($folderName)
    {
        $response = $this->client->request(
            'POST',
            "{$this->getResourcePath()}/folders",
            [
                RequestOptions::JSON => [
                    'name' => $folderName
                ]
            ]
        );

        $decodedResponse = json_decode($response->getBody()->getContents());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException(json_last_error_msg());
        }

        return $decodedResponse;
    }

    /**
     * Delete an existing folder
     *
     * @param int $folderId
     * @throws ApiException
     */
    public function delete($folderId)
    {
        $response = $this->client->request(
            'DELETE',
            "{$this->getResourcePath()}/folders/{$folderId}"
        );
    }

    /**
     * Rename an existing folder
     *
     * @param int $folderId
     * @param string $newFolderName
     * @return stdClass
     * @throws ApiException
     */
    public function rename($folderId, $newFolderName)
    {
        $response = $this->client->request(
            'PATCH',
            "{$this->getResourcePath()}/folders/{$folderId}",
            [
                RequestOptions::JSON => [
                    'name' => $newFolderName
                ]
            ]
        );

        $decodedResponse = json_decode($response->getBody()->getContents());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException(json_last_error_msg());
        }

        return $decodedResponse;
    }

    /**
     * Assign mailing to a folder
     *
     * @param int $mailingId
     * @param int|null $folderId
     * @return stdClass
     * @throws ApiException
     */
    public function assign($mailingId, $folderId)
    {
        $response = $this->client->request(
            'PUT',
            "{$this->getResourcePath()}/{$mailingId}/folder",
            [
                RequestOptions::JSON => [
                    'folder_id' => $folderId
                ]
            ]
        );

        $decodedResponse = json_decode($response->getBody()->getContents());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException(json_last_error_msg());
        }

        return $decodedResponse;
    }

    /**
     * Remove folder assignment of mailing
     *
     * @param int $mailingId
     * @param int $folderId
     * @return stdClass
     * @throws ApiException
     */
    public function removeAssignment($mailingId)
    {
        return $this->assign($mailingId, null);
    }
}
