<?php

declare(strict_types=1);

namespace ColinHDev\CPlot\plots;

use ColinHDev\CPlot\player\PlayerData;

class PlotPlayer {

    public const STATE_OWNER = "state_owner";
    public const STATE_TRUSTED = "state_trusted";
    public const STATE_HELPER = "state_helper";
    public const STATE_DENIED = "state_denied";

    private PlayerData $playerData;
    /** @phpstan-var PlotPlayer::STATE_* */
    private string $state;
    private int $addTime;

    /**
     * @phpstan-param PlotPlayer::STATE_* $state
     */
    public function __construct(PlayerData $playerData, string $state, ?int $addTime = null) {
        $this->playerData = $playerData;
        $this->state = $state;
        $this->addTime = $addTime ?? time();
    }

    public function getPlayerData() : PlayerData {
        return $this->playerData;
    }

    /**
     * @phpstan-return PlotPlayer::STATE_*
     */
    public function getState() : string {
        return $this->state;
    }

    public function getAddTime() : int {
        return $this->addTime;
    }

    public function toString() : string {
        return PlayerData::getIdentifierFromData($this->playerData->getPlayerUUID(), $this->playerData->getPlayerXUID(), $this->playerData->getPlayerName());
    }

    /**
     * @phpstan-return array{playerData: string, state: PlotPlayer::STATE_*, addTime: int}
     */
    public function __serialize() : array {
        return [
            "playerData" => serialize($this->playerData),
            "state" => $this->state,
            "addTime" => $this->addTime
        ];
    }

    /**
     * @phpstan-param array{playerData: string, state: PlotPlayer::STATE_*, addTime: int} $data
     */
    public function __unserialize(array $data) : void {
        $playerData = unserialize($data["playerData"], ["allowed_classes" => [PlayerData::class]]);
        assert($playerData instanceof PlayerData);
        $this->playerData = $playerData;
        $this->state = $data["state"];
        $this->addTime = $data["addTime"];
    }
}