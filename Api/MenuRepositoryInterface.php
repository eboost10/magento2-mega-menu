<?php
namespace EBoost\Menu\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use EBoost\Menu\Api\Data\MenuInterface;

interface MenuRepositoryInterface
{
    /**
     * @param string $identifier
     * @param int $storeId
     * @return \EBoost\Menu\Model\Menu
     * @throws NoSuchEntityException
     */
    public function get($identifier, $storeId);

    /**
     * @param \EBoost\Menu\Api\Data\MenuInterface $page
     * @return \EBoost\Menu\Api\Data\MenuInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(MenuInterface $page);

    /**
     * @param int $id
     * @return \EBoost\Menu\Model\Menu
     */
    public function getById($id);

    /**
     * Returns menus list
     *
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \EBoost\Menu\Api\Data\MenuSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * @param \EBoost\Menu\Api\Data\MenuInterface $page
     * @return bool
     */
    public function delete(MenuInterface $page);

    /**
     * Removes Menu with all nodes belonging to it
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id);

    /**
     * Updates is_active for given menu ids
     *
     * @param array $ids
     * @param int $isActive
     * @return bool
     */
    public function setIsActiveByIds($ids, $isActive);
}
