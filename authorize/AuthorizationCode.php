<?php

namespace app\authorize;

use app\authorize\repositories\db\AuthCodeRepository;
use app\authorize\repositories\db\RefreshTokenRepository;
use app\authorize\repositories\db\ScopeRepository;
use app\authorize\repositories\db\AccessTokenRepository;
use app\authorize\repositories\db\ClientRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use yii\base\Component;

class AuthorizationCode extends Component implements GrantInterface
{
    /**
     * @var string
     */
    public $privateKeyPath;

    /**
     * @var string
     */
    public $publicKeyPath;

    /**
     * @var string
     */
    public $encryptionKey;

    /**
     * @var string
     */
    public $codeTTL = 'PT10M';

    /**
     * @var string
     */
    public $refreshTokenTTL = 'P1M';

    /**
     * @var string
     */
    public $accessTokenTTL = 'PT1H';

    /**
     * @return AuthorizationServer
     */
    public function handle()
    {
        $clientRepository = new ClientRepository();
        $scopeRepository = new ScopeRepository();
        $accessTokenRepository = new AccessTokenRepository();
        $authCodeRepository = new AuthCodeRepository();
        $refreshTokenRepository = new RefreshTokenRepository();

        $server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $this->privateKeyPath,
            $this->encryptionKey
        );

        $grant = new AuthCodeGrant(
            $authCodeRepository,
            $refreshTokenRepository,
            new \DateInterval($this->codeTTL)
        );

        $grant->setRefreshTokenTTL(new \DateInterval($this->refreshTokenTTL));

        $server->enableGrantType(
            $grant,
            new \DateInterval($this->accessTokenTTL)
        );

        return $server;
    }

}