<?php

namespace App\Infrastructure\Repository;

use App\Domain\Post\Post;
use App\Domain\Post\PostRepositoryInterface;
use Doctrine\ORM\EntityManager;

class PostRepository implements PostRepositoryInterface
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @param Post $post
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function create(Post $post): void
	{
		$this->entityManager->persist($post);
		$this->entityManager->flush();
	}

	/**
	 * @param Post $post
	 * @param array $data
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function update(Post $post, $data = []): void
	{
		$post->setTitle($data['title']);
		$post->setBody($data['body']);
		$this->entityManager->persist($post);
		$this->entityManager->flush();
	}

	/**
	 * @param int $id
	 * @return Post|null
	 */
	public function findById(int $id): ?Post
	{
		return $this->entityManager->getRepository(Post::class)->findOneBy([
			'id' => $id
		]);
	}

	/**
	 * @param Post $post
	 * @return mixed|void
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function delete(Post $post)
	{
		$this->entityManager->remove($post);
		$this->entityManager->flush();
	}

	/**
	 * @param array $data
	 * @return Post
	 * @throws \Exception
	 */
	public function prepareData($data = []): Post
	{
		return new Post($data['tittle'] ?? '',
			$data['body'] ?? '',
			new \DateTime(), new \DateTime()
		);
	}
}