<?php
require_once 'gameData.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Функція для отримання списку ігор з найбільшими знижками або популярних ігор
function fetchDeals($sortBy) {
    $url = "https://www.cheapshark.com/api/1.0/deals?sortBy={$sortBy}&desc=1&pageSize=5";

    $context = stream_context_create(['http' => ['timeout' => 5]]);
    $json = @file_get_contents($url, false, $context);

    if ($json === false) {
        return false;
    }

    $data = json_decode($json, true);
    return is_array($data) ? $data : false;
}

if ($searchQuery) {
    $games = [$searchQuery];
} else {
    $topDiscounts = fetchDeals('Savings');
    $topPopular = fetchDeals('DealRating');
}
?>

<?php include 'parts/header.php'; ?>

<div class="game-container">

    <?php if ($searchQuery): ?>
        <?php foreach ($games as $gameName): 
            $game = getGameInfo($gameName);
            if ($game):
        ?>
            <div class="game">
                <a href="gameinfo.php?game=<?php echo urlencode($game['external']); ?>" class="game-link">
                    <img src="<?php echo $game['thumb']; ?>" alt="<?php echo htmlspecialchars($game['external']); ?>">
                    <div class="game-title"><?php echo htmlspecialchars($game['external']); ?></div>
                    <div class="price">
                        Ціна:
                        <span class="price-usd" data-price="<?php echo $game['cheapest']; ?>">
                            <?php echo $game['cheapest']; ?>
                        </span>
                        <span class="price-symbol">$</span>
                    </div>
                </a>
            </div>
        <?php else: ?>
            <div class="game">
                <div class="game-title"><?php echo htmlspecialchars($gameName); ?></div>
                <div class="price">Гру не знайдено</div>
            </div>
        <?php endif; endforeach; ?>

    <?php else: ?>

        <div class="section-header">
            <h2 class="section-title">Найбільші знижки</h2>
            <a href="lists/discounts.php" class="see-all-button">→ Повний список</a>
        </div>

        <div class="game-container">
            <?php if ($topDiscounts === false || empty($topDiscounts)): ?>
                <p>Не вдалося завантажити список знижок. Спробуйте пізніше.</p>
            <?php else: ?>
                <?php foreach ($topDiscounts as $game): ?>
                    <div class="game">
                        <a href="gameinfo.php?game=<?php echo urlencode($game['title']); ?>" class="game-link">
                            <img src="<?php echo $game['thumb']; ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
                            <div class="game-title"><?php echo htmlspecialchars($game['title']); ?></div>
                            <div class="price">
                                <span class="price-usd" data-price="<?php echo $game['salePrice']; ?>">
                                    <?php echo number_format($game['salePrice'], 2); ?>
                                </span>
                                <span class="price-symbol">$</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="section-header">
            <h2 class="section-title">Найпопулярніші ігри</h2>
            <a href="lists/popular.php" class="see-all-button">→ Повний список</a>
        </div>

        <div class="game-container">
            <?php if ($topPopular === false || empty($topPopular)): ?>
                <p>Не вдалося завантажити список популярних ігор. Спробуйте пізніше.</p>
            <?php else: ?>
                <?php foreach ($topPopular as $game): ?>
                    <div class="game">
                        <a href="gameinfo.php?game=<?php echo urlencode($game['title']); ?>" class="game-link">
                            <img src="<?php echo $game['thumb']; ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
                            <div class="game-title"><?php echo htmlspecialchars($game['title']); ?></div>
                            <div class="price">
                                <span class="price-usd" data-price="<?php echo $game['salePrice']; ?>">
                                    <?php echo number_format($game['salePrice'], 2); ?>
                                </span>
                                <span class="price-symbol">$</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>

<?php include 'parts/footer.php'; ?>
