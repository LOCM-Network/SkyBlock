<?php

namespace ColinHDev\CPlot\tasks\utils;

use ColinHDev\CPlotAPI\BasePlot;
use ColinHDev\CPlotAPI\math\Area;
use ColinHDev\CPlotAPI\Plot;
use ColinHDev\CPlotAPI\worlds\WorldSettings;
use pocketmine\math\Facing;

trait RoadAreaCalculationTrait {

    /**
     * @return Area[]
     * Returns all areas of merged roads. This doesn't include the base plot areas.
     */
    private function calculateMergeRoadAreas(WorldSettings $worldSettings, Plot $originPlot) : array {
        /** @var Area[] $areas */
        $areas = [];

        $plots = array_merge([$originPlot], $originPlot->getMergedPlots() ?? []);
        /** @var BasePlot $plot */
        foreach ($plots as $plot) {
            $plotPosition = $plot->getPositionNonNull($worldSettings->getRoadSize(), $worldSettings->getPlotSize(), $worldSettings->getGroundSize());

            $plotInNorth = $plot->getSide(Facing::NORTH);
            $plotInNorthWest = $plotInNorth->getSide(Facing::WEST);
            $plotInNorthEast = $plotInNorth->getSide(Facing::EAST);
            $plotInSouth = $plot->getSide(Facing::SOUTH);
            $plotInSouthWest = $plotInSouth->getSide(Facing::WEST);
            $plotInSouthEast = $plotInSouth->getSide(Facing::EAST);
            $plotInWest = $plot->getSide(Facing::WEST);
            $plotInEast = $plot->getSide(Facing::EAST);

            if ($plot->isMerged($plotInNorth)) {
                if ($plot->isMerged($plotInWest) && $plot->isMerged($plotInNorthWest)) {
                    $areaXMin = $plotPosition->getFloorX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getFloorZ() - $worldSettings->getRoadSize();
                } else {
                    $areaXMin = $plotPosition->getFloorX();
                    $areaZMin = $plotPosition->getFloorZ() - $worldSettings->getRoadSize();
                }
                if ($plot->isMerged($plotInEast) && $plot->isMerged($plotInNorthEast)) {
                    $areaXMax = $plotPosition->getFloorX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getFloorZ() - 1;
                } else {
                    $areaXMax = $plotPosition->getFloorX() + ($worldSettings->getPlotSize() - 1);
                    $areaZMax = $plotPosition->getFloorZ() - 1;
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }

            if ($plot->isMerged($plotInSouth)) {
                if ($plot->isMerged($plotInWest) && $plot->isMerged($plotInSouthWest)) {
                    $areaXMin = $plotPosition->getFloorX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getFloorZ() + $worldSettings->getPlotSize();
                } else {
                    $areaXMin = $plotPosition->getFloorX();
                    $areaZMin = $plotPosition->getFloorZ() + $worldSettings->getPlotSize();
                }
                if ($plot->isMerged($plotInEast) && $plot->isMerged($plotInSouthEast)) {
                    $areaXMax = $plotPosition->getFloorX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getFloorZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else {
                    $areaXMax = $plotPosition->getFloorX() + ($worldSettings->getPlotSize() - 1);
                    $areaZMax = $plotPosition->getFloorZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }

            if ($plot->isMerged($plotInWest)) {
                if ($plot->isMerged($plotInNorth) && $plot->isMerged($plotInNorthWest)) {
                    $areaXMin = $plotPosition->getFloorX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getFloorZ() - $worldSettings->getRoadSize();
                } else {
                    $areaXMin = $plotPosition->getFloorX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getFloorZ();
                }
                if ($plot->isMerged($plotInSouth) && $plot->isMerged($plotInSouthWest)) {
                    $areaXMax = $plotPosition->getFloorX() - 1;
                    $areaZMax = $plotPosition->getFloorZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else {
                    $areaXMax = $plotPosition->getFloorX() - 1;
                    $areaZMax = $plotPosition->getFloorZ() + ($worldSettings->getPlotSize() - 1);
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }

            if ($plot->isMerged($plotInEast)) {
                if ($plot->isMerged($plotInNorth) && $plot->isMerged($plotInNorthEast)) {
                    $areaXMin = $plotPosition->getFloorX() + $worldSettings->getPlotSize();
                    $areaZMin = $plotPosition->getFloorZ() - $worldSettings->getRoadSize();
                } else {
                    $areaXMin = $plotPosition->getFloorX() + $worldSettings->getPlotSize();
                    $areaZMin = $plotPosition->getFloorZ();
                }
                if ($plot->isMerged($plotInSouth) && $plot->isMerged($plotInSouthEast)) {
                    $areaXMax = $plotPosition->getFloorX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getFloorZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                }  else {
                    $areaXMax = $plotPosition->getFloorX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getFloorZ() + ($worldSettings->getPlotSize() - 1);
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }
        }

        return $areas;
    }

    /**
     * @return Area[]
     * Returns all areas of roads that aren't merged between two different plots.
     */
    private function calculateNonMergeRoadAreas(WorldSettings $worldSettings, Plot $originPlot, Plot $mergePlot) : array {
        /** @var Area[] $areas */
        $areas = [];

        $plots = array_merge([$originPlot], $originPlot->getMergedPlots() ?? []);
        /** @var BasePlot $plot */
        foreach ($plots as $plot) {
            $plotPosition = $plot->getPositionNonNull($worldSettings->getRoadSize(), $worldSettings->getPlotSize(), $worldSettings->getGroundSize());

            $plotInNorth = $plot->getSide(Facing::NORTH);
            $plotInNorthWest = $plotInNorth->getSide(Facing::WEST);
            $plotInNorthEast = $plotInNorth->getSide(Facing::EAST);
            $plotInSouth = $plot->getSide(Facing::SOUTH);
            $plotInSouthWest = $plotInSouth->getSide(Facing::WEST);
            $plotInSouthEast = $plotInSouth->getSide(Facing::EAST);
            $plotInWest = $plot->getSide(Facing::WEST);
            $plotInEast = $plot->getSide(Facing::EAST);

            if (!$plot->isMerged($plotInNorth) && $mergePlot->isMerged($plotInNorth)) {
                if ($plot->isMerged($plotInWest) && ($plot->isMerged($plotInNorthWest) || $mergePlot->isMerged($plotInNorthWest))) {
                    $areaXMin = $plotPosition->getX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getZ() - $worldSettings->getRoadSize();
                } else if ($mergePlot->isMerged($plotInWest) && $mergePlot->isMerged($plotInNorthWest)) {
                    $areaXMin = $plotPosition->getX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getZ() - $worldSettings->getRoadSize();
                } else {
                    $areaXMin = $plotPosition->getX();
                    $areaZMin = $plotPosition->getZ() - $worldSettings->getRoadSize();
                }
                if ($plot->isMerged($plotInEast) && ($plot->isMerged($plotInNorthEast) || $mergePlot->isMerged($plotInNorthEast))) {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getZ() - 1;
                } else if ($mergePlot->isMerged($plotInEast) && $mergePlot->isMerged($plotInNorthEast)) {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getZ() - 1;
                } else {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() - 1);
                    $areaZMax = $plotPosition->getZ() - 1;
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }

            if (!$plot->isMerged($plotInSouth) && $mergePlot->isMerged($plotInSouth)) {
                if ($plot->isMerged($plotInWest) && ($plot->isMerged($plotInSouthWest) || $mergePlot->isMerged($plotInSouthWest))) {
                    $areaXMin = $plotPosition->getX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getZ() + $worldSettings->getPlotSize();
                } else if ($mergePlot->isMerged($plotInWest) && $mergePlot->isMerged($plotInSouthWest)) {
                    $areaXMin = $plotPosition->getX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getZ() + $worldSettings->getPlotSize();
                } else {
                    $areaXMin = $plotPosition->getX();
                    $areaZMin = $plotPosition->getZ() + $worldSettings->getPlotSize();
                }
                if ($plot->isMerged($plotInEast) && ($plot->isMerged($plotInSouthEast) || $mergePlot->isMerged($plotInSouthEast))) {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else if ($mergePlot->isMerged($plotInWest) && $mergePlot->isMerged($plotInSouthEast)) {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() - 1);
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }

            if (!$plot->isMerged($plotInWest) && $mergePlot->isMerged($plotInWest)) {
                if ($plot->isMerged($plotInNorth) && ($plot->isMerged($plotInNorthWest) || $mergePlot->isMerged($plotInNorthWest))) {
                    $areaXMin = $plotPosition->getX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getZ() - $worldSettings->getRoadSize();
                } else if ($mergePlot->isMerged($plotInNorth) && $mergePlot->isMerged($plotInNorthWest)) {
                    $areaXMin = $plotPosition->getX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getZ() - $worldSettings->getRoadSize();
                } else {
                    $areaXMin = $plotPosition->getX() - $worldSettings->getRoadSize();
                    $areaZMin = $plotPosition->getZ();
                }
                if ($plot->isMerged($plotInSouth) && ($plot->isMerged($plotInSouthWest) || $mergePlot->isMerged($plotInSouthWest))) {
                    $areaXMax = $plotPosition->getX() - 1;
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else if ($mergePlot->isMerged($plotInSouth) && $mergePlot->isMerged($plotInSouthWest)) {
                    $areaXMax = $plotPosition->getX() - 1;
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else {
                    $areaXMax = $plotPosition->getX() - 1;
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() - 1);
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }

            if (!$plot->isMerged($plotInEast) && $mergePlot->isMerged($plotInEast)) {
                if ($plot->isMerged($plotInNorth) && ($plot->isMerged($plotInNorthEast) || $mergePlot->isMerged($plotInNorthEast))) {
                    $areaXMin = $plotPosition->getX() + $worldSettings->getPlotSize();
                    $areaZMin = $plotPosition->getZ() - $worldSettings->getRoadSize();
                } else if ($mergePlot->isMerged($plotInNorth) && $mergePlot->isMerged($plotInNorthEast)) {
                    $areaXMin = $plotPosition->getX() + $worldSettings->getPlotSize();
                    $areaZMin = $plotPosition->getZ() - $worldSettings->getRoadSize();
                } else {
                    $areaXMin = $plotPosition->getX() + $worldSettings->getPlotSize();
                    $areaZMin = $plotPosition->getZ();
                }
                if ($plot->isMerged($plotInSouth) && ($plot->isMerged($plotInSouthEast) || $mergePlot->isMerged($plotInSouthEast))) {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else if ($mergePlot->isMerged($plotInSouth) && $mergePlot->isMerged($plotInSouthEast)) {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                } else {
                    $areaXMax = $plotPosition->getX() + ($worldSettings->getPlotSize() + $worldSettings->getRoadSize() - 1);
                    $areaZMax = $plotPosition->getZ() + ($worldSettings->getPlotSize() - 1);
                }
                $area = new Area($areaXMin, $areaZMin, $areaXMax, $areaZMax);
                $key = $area->toString();
                if (!isset($areas[$key])) {
                    $areas[$key] = $area;
                }
            }
        }

        return $areas;
    }
}