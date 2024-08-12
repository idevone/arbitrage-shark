const { cardRegex, cryptoRegex } = require("./regex");
const findCards = (text) => {
  // Знаходимо банківські картки
  const cards = text.match(cardRegex) || [];

  // Знаходимо крипто-гаманці і додаємо їх до масиву карток
  Object.keys(cryptoRegex).forEach((crypto) => {
    const matches = text.match(cryptoRegex[crypto]);
    if (matches) {
      cards.push(...matches);
    }
  });

  return cards;
};

const cleanCardNumber = (card) => {
  return card.replace(/[\s-]/g, "");
};

const cardVerification = (cards, validCards) => {
  return cards.every((card) => {
    const cleanedCard = cleanCardNumber(card);
    return validCards.some(
      (validCard) => cleanCardNumber(validCard) === cleanedCard
    );
  });
};

module.exports = { findCards, cardVerification };
