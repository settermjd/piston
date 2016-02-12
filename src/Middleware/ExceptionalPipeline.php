<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Piston\Middleware;

use InvalidArgumentException;
use League\Pipeline\PipelineInterface;
use League\Pipeline\StageInterface;

class ExceptionalPipeline implements PipelineInterface
{
    /**
     * @var StageInterface[]
     */
    private $stages = [];

    /**
     * @param StageInterface[] $stages
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $stages = [])
    {
        foreach ($stages as $stage) {
            if (!$stage instanceof StageInterface) {
                throw new InvalidArgumentException('All stages should implement the ' . StageInterface::class);
            }
        }

        $this->stages = $stages;
    }

    /**
     * @param StageInterface $stage
     *
     * @return static
     */
    public function pipe(StageInterface $stage)
    {
        $this->stages[] = $stage;

        return new static($this->stages);
    }

    /**
     * {@inheritdoc}
     */
    public function process($payload)
    {
        $reducer = function ($payload, StageInterface $stage) {
            return $stage->process($payload);
        };

        foreach ($this->stages as $stage) {
            $payload = $reducer($payload, $stage);
        }

        return $payload;
    }
}
