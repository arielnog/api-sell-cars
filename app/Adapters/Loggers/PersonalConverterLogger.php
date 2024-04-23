<?php

namespace App\Adapters\Loggers;

use App\Exceptions\CustomException;
use App\Exceptions\CustomValidateException;
use Exception;
use Illuminate\Support\Arr;
use MarvinLabs\DiscordLogger\Contracts\DiscordWebHook;
use MarvinLabs\DiscordLogger\Converters\AbstractRecordConverter;
use MarvinLabs\DiscordLogger\Discord\Embed;
use MarvinLabs\DiscordLogger\Discord\Exceptions\ConfigurationIssue;
use MarvinLabs\DiscordLogger\Discord\Message;
use Throwable;

class PersonalConverterLogger extends AbstractRecordConverter
{
    /**
     */
    public function buildMessages(array $record): array
    {
        $fileMessage = null;
        $mainMessage = Message::make();

        $this->addGenericMessageFrom($mainMessage);
        $this->addMainEmbed($mainMessage, $record);
        $stacktrace = $this->getTrace($record);

        if (!is_null($stacktrace)) {
            $this->addInlineMessageStacktrace($mainMessage, $record, $stacktrace);

            if (strlen($record['formatted']) > DiscordWebHook::MAX_CONTENT_LENGTH)
            {
                $fileName = $record['datetime']->format('y-m-d-h-i-s');
                $fileContent = json_encode($stacktrace->getTrace(),JSON_PRETTY_PRINT);

                $fileMessage = Message::make()->file($fileContent, "{$fileName}.json");
                $this->addGenericMessageFrom($fileMessage);
            }
        }

        return $fileMessage !== null ? [$mainMessage, $fileMessage] : [$mainMessage];
    }

    protected function addMainEmbed(Message $message, array $record): void
    {
        $timestamp = $record['datetime']->format('Y-m-d H:i:s');
        $title = "[{$record['level_name']}][$timestamp] - {$record['message']}";
        $description = json_encode($this->buildDescription($record), JSON_PRETTY_PRINT);
        $emoji = $this->getRecordEmoji($record);

        $message->embed(Embed::make()
            ->color($this->getRecordColor($record))
            ->title($emoji === null ? "`$title`" : "$emoji `$title`")
            ->description("``` {$description} ```"));
    }

    protected function buildDescription(array $record): array
    {
        $content = [];
        $context = $record['context'];

        if (isset($context['exception'])) {
            $exception = $context['exception'];

            $content['exception'] = [
                'application_code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'status_code' => $exception->getStatusCode()
            ];

            if ($exception instanceof CustomValidateException){
                $content['exception']['validate'] = $exception->getOnlyMessages();
            }
        }

        if (isset($context['data'])) {
            foreach ($context['data'] as $key => $value) {
                $content['data'][$key] = $value;
            }
        }

        return $content;
    }

    protected function addInlineMessageStacktrace(Message $message, array $record, Exception $stacktrace): void
    {
        $stringTrace = str_replace('#', '- ', $stacktrace->getTraceAsString());

        $message->embed(Embed::make()
            ->color($this->getRecordColor($record))
            ->title('Exception')
            ->description(" $stringTrace "));
    }

    protected function getTrace(array $record): ?Exception
    {
        if (!is_a($record['context']['exception'] ?? '', Throwable::class)) {
            return null;
        }

        return $record['context']['exception'];
    }
}

