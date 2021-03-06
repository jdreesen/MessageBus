<?php

namespace SimpleBus\Message\Recorder;

class AggregatesRecordedMessages implements RecordsMessages
{
    /**
     * @var RecordsMessages[]
     */
    private $messageRecorders;

    public function __construct(array $messageRecorders)
    {
        foreach ($messageRecorders as $messageRecorder) {
            $this->addMessageRecorder($messageRecorder);
        }

        $this->messageRecorders = $messageRecorders;
    }

    /**
     * Get messages recorded by all known message recorders.
     *
     * {@inheritdoc}
     */
    public function recordedMessages()
    {
        $allRecordedMessages = array();

        foreach ($this->messageRecorders as $messageRecorder) {
            $allRecordedMessages = array_merge($allRecordedMessages, $messageRecorder->recordedMessages());
        }

        return $allRecordedMessages;
    }

    /**
     * Erase messages recorded by all known message recorders.
     *
     * {@inheritdoc}
     */
    public function eraseMessages()
    {
        foreach ($this->messageRecorders as $messageRecorder) {
            $messageRecorder->eraseMessages();
        }
    }

    private function addMessageRecorder(RecordsMessages $messageRecorder)
    {
        $this->messageRecorders[] = $messageRecorder;
    }
}
