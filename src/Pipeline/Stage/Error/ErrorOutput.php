<?php

namespace Refinery29\Piston\Pipeline\Stage\Error;

use League\Pipeline\StageInterface;

class ErrorOutput implements StageInterface
{

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload)
    {

        /** @var Error[] $errors */
        $errors = $payload->getErrors();

        if ($errors) {
            $content = $payload->getContent();
            $errorOutput = '';

            foreach ($errors as $error) {
                $errorOutput .= $this->buildError($error);
            }

            $payload->setContent($content . $this->compileErrors($errorOutput));
        }

        return $payload;
    }

    /**
     * @param Error $error
     * @return string
     */
    private function buildError(Error $error)
    {
        return "hello";
    }

    /**
     * @param string $errorOutput
     * @return string
     */
    private function compileErrors($errorOutput)
    {
        return "array of hello";
    }
}
