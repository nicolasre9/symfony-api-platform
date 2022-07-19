<?php

    namespace App\Api\Listener;

    //use Exception;
    use Symfony\Component\HttpKernel\Event\ExceptionEvent;
    use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

    class JsonExceptionResponseTransformerListener
    {
        public function onKernelException(Exception $event): void
        {
            $exception = $event->getThrowable();

            if  ($exception instanceof HttpExceptionInterface) {
                $data = [
                    'class' => get_class($exception),
                    'code' => $exception->getSatusCode(),
                    'message' => $exception->getMessage(),
                ];

                $event->setResponse($this->prepareResponse($data, $data['code']));
            }

        }

        private function prepareResponse(array $data, int $statusCode): JsonResponse
        {
            $response = new JsonResponse($data, $statusCode);
            $response->headers->set('Server-Time', time());
            $response->headers->set('X-Error-Code', $statusCode);

            return $response;
        }
    }

?>