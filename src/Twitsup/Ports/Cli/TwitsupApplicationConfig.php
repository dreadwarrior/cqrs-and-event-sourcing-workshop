<?php

namespace Twitsup\Ports\Cli;

use Interop\Container\ContainerInterface;
use Webmozart\Console\Api\Args\Format\Argument;
use Webmozart\Console\Api\Formatter\Style;
use Webmozart\Console\Config\DefaultApplicationConfig;

class TwitsupApplicationConfig extends DefaultApplicationConfig
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct(null, null);

        $this->container = $container;
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('twitsup')
            ->setVersion('1.0.0')
            ->addStyle(Style::tag('success')->fgGreen())
            ->addStyle(Style::tag('data')->fgYellow())
            ->beginCommand('register-user')
                ->setDescription('Register a new user')
                ->addArgument('username', Argument::REQUIRED, 'Username')
                ->addArgument('nickname', Argument::REQUIRED, 'Nickname (e.g. full name)')
                ->setHandler(function () {
                    return $this->container->get(RegisterUserCliHandler::class);
                })
            ->end()
            ->beginCommand('follow-user')
                ->setDescription('Follow a user')
                ->addArgument('follower', Argument::REQUIRED, 'The username of the follower')
                ->addArgument('followee', Argument::REQUIRED, 'The username of the followee')
                ->setHandler(function () {
                    return $this->container->get(FollowUserCliHandler::class);
                })
            ->end()
            ->beginCommand('tweet')
                ->setDescription('Send a tweet')
                ->addArgument('username', Argument::REQUIRED, 'Name')
                ->addArgument('text', Argument::REQUIRED, 'Text')
                ->setHandler(function () {
                    return $this->container->get(SendTweetCliHandler::class);
                })
            ->end()
        ;
    }
}
