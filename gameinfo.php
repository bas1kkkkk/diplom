<?php
require_once 'gameData.php';

$gameName = isset($_GET['game']) ? $_GET['game'] : '';
$game = getGameInfo($gameName);

if ($game) {
    $deals = getGameDeals($game['gameID']);
    $stores = getStoresMap(); // Получаем соответствие storeID => storeName
}
?>

<?php include 'parts/header.php'; ?>

<div class="gameinfo">
    <?php if ($game): ?>
        <h1><?php echo htmlspecialchars($game['external']); ?></h1>
        <img src="<?php echo $game['thumb']; ?>" alt="<?php echo htmlspecialchars($game['external']); ?>">

        <?php if (!empty($deals)): ?>
            <h2>Доступні ціни:</h2>
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
        <?php else: ?>
            <p>Немає доступних знижок для цієї гри.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Гру не знайдено.</p>
    <?php endif; ?>
</div>

<?php include 'parts/footer.php'; ?>
