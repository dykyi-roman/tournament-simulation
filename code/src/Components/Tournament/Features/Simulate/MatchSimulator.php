<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Simulate;

final class MatchSimulator
{
    public function __construct(private MatchRepositoryInterface $matchRepository)
    {
    }

    public function simulate(array $teams, int $matchNumber): void
    {
        $matches = [];
        $teamsCount = count($teams);
        for ($i = 1; $i <= $teamsCount; ++$i) {
            for ($j = $i + 1; $j <= $teamsCount; ++$j) {
                $matches[] = [$teams[$i - 1], $teams[$j - 1]];
            }
        }

        $pair = $matches[$matchNumber];
        $result = [random_int(0, 5), random_int(0, 5)];

        $this->matchRepository->create(
            $pair[0],
            (int) ($result[0] > $result[1]),
            (int) ($result[0] === $result[1]),
            (int) ($result[0] < $result[1]),
            (int) $result[0],
            (int) $result[1]
        );

        $this->matchRepository->create(
            $pair[1],
            (int) ($result[0] < $result[1]),
            (int) ($result[0] === $result[1]),
            (int) ($result[0] > $result[1]),
            (int) $result[1],
            (int) $result[0]
        );
    }
}
