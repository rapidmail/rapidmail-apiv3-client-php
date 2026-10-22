<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingFolders;

use GuzzleHttp\RequestOptions;
use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Service\AbstractService;
use stdClass;

class MailingFoldersService extends AbstractService
{
    /**
     * @inheritDoc
     */
    protected function getResourcePath(): string
    {
        return 'mailings';
    }

    /**
     * Fetch all mailing folders as array
     *
     * @throws ApiException
     */
    public function fetchAll(): array
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
            return[];
        }

        return $decodedResponse->folders;
    }

    /**
     * Create a new folder
     *
     * @return stdClass
     * @throws ApiException
     */
    public function create(string $folderName)
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
     * @throws ApiException
     */
    public function delete(int $folderId): void
    {
        $response = $this->client->request(
            'DELETE',
            "{$this->getResourcePath()}/folders/{$folderId}"
        );
    }

    /**
     * Rename an existing folder
     *
     * @return stdClass
     * @throws ApiException
     */
    public function rename(int $folderId, string $newFolderName)
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
     * @return stdClass
     * @throws ApiException
     */
    public function assign(int $mailingId, ?int $folderId)
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
     * @return stdClass
     * @throws ApiException
     */
    public function removeAssignment(int $mailingId)
    {
        return $this->assign($mailingId, null);
    }
}
