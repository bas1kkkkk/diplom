<?php
require_once '<api/gameData.php';

$gameName = isset($_GET['game']) ? $_GET['game'] : '';
$game = getGameInfo($gameName);
$rawgInfo = getRawgInfo($gameName); 
$deals = $game ? getGameDeals($game['gameID']) : [];
$stores = getStoresMap();
?>

<?php include 'parts/header.php'; ?>

<div class="gameinfo">
    <div class="game-media">
        <!-- Ціни в магазинах -->
        <div class="deals">
            <h2>Ціни в магазинах:</h2>
            <ul>
                <?php foreach ($deals as $deal): ?>
                    <li>
                        <a href="https://www.cheapshark.com/redirect?dealID=<?php echo $deal['dealID']; ?>" target="_blank">
                            <span class="price-usd" data-price="<?php echo $deal['price']; ?>">
                                <?php echo $deal['price']; ?>
                            </span>
                            <span class="price-symbol">$</span>
                            —
                            <?php
                                $storeName = isset($stores[$deal['storeID']]) ? $stores[$deal['storeID']] : 'Невідомий магазин';
                                echo htmlspecialchars($storeName);
                            ?>
                            <small>(Знижка: <?php echo round($deal['savings']); ?>%)</small>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="main-screenshot-container">
            <button class="arrow-left">&#8592;</button>
                <img id="main-screenshot"
                    src="<?php echo htmlspecialchars($rawgInfo['screenshots'][0]['image'] ?? ''); ?>"
                    alt="Main Screenshot"
                    style="width: 80%; max-width: 800px; border-radius: 10px; object-fit: cover;">
                <button class="arrow-right">&#8594;</button>
        </div>
    </div>

    <div class="game-details">
        <h1><?php echo htmlspecialchars($rawgInfo['name'] ?? $game['external']); ?></h1>

        <p><strong>Рейтинг:</strong> <?php echo $rawgInfo['rating'] ?? 'N/A'; ?></p>

        <p><strong>Жанри:</strong>
            <?php
            if (!empty($rawgInfo['genres'])) {
                foreach ($rawgInfo['genres'] as $genre) {
                    echo '<span class="tag">' . htmlspecialchars($genre['name']) . '</span> ';
                }
            }
            ?>
        </p>

        <p><strong>Теги:</strong>
            <?php
            if (!empty($rawgInfo['tags'])) {
                foreach (array_slice($rawgInfo['tags'], 0, 5) as $tag) {
                    echo '<span class="tag">' . htmlspecialchars($tag['name']) . '</span> ';
                }
            }
            ?>
        </p>

        <p><strong>Час гри:</strong> <?php echo $rawgInfo['playtime'] ?? 'N/A'; ?> годин</p>

        <p><strong>Дата релізу:</strong> <?php echo $rawgInfo['released'] ?? 'N/A'; ?></p>

        <p><strong>Metacritic:</strong> <?php echo $rawgInfo['metacritic'] ?? 'N/A'; ?></p>
        <p><a href="<?php echo $rawgInfo['metacritic_url'] ?? '#'; ?>" target="_blank">Переглянути на Metacritic</a></p>
    </div>
</div>

<script id="screenshot-data" type="application/json">
    <?php echo json_encode($rawgInfo['screenshots']); ?>
</script>

<?php include 'parts/footer.php'; ?>
