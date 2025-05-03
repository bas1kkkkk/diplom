<?php
require_once 'gameData.php';

$gameName = isset($_GET['game']) ? $_GET['game'] : '';
$game = getGameInfo($gameName);
$rawgInfo = getRawgInfo($gameName); 
$deals = $game ? getGameDeals($game['gameID']) : [];
$stores = getStoresMap();
?>

<?php include 'parts/header.php'; ?>

<div class="gameinfo">
    <div class="game-media">
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

        <img src="<?php echo htmlspecialchars($rawgInfo['image'] ?? $game['thumb']); ?>"
             alt="<?php echo htmlspecialchars($rawgInfo['name'] ?? $game['external']); ?>"
             class="main-screenshot">

        
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
    </div>
</div>

<?php include 'parts/footer.php'; ?>
