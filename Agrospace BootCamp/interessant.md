
  /**
     * Retourne les listeners dynamiquement selon la conversation active
     */
    protected function getListeners()
    {
        $listeners = [
            'conversationSelected' => 'loadConversation',
            'messageSent' => 'handleMessageSent',
        ];

        if ($this->conversation) {
            $channel = 'echo-private:conversation.' . $this->conversation->id;
            $listeners[$channel . ',MessageSent'] = 'handleNewMessage';
            $listeners[$channel . ',UserTyping'] = 'handleUserTyping';
            $listeners[$channel . ',MessageRead'] = 'handleMessageRead';
        }

        return $listeners;
    }