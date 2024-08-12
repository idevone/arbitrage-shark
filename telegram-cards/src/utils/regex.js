const cardRegex = /\b(?:\d[ -]*?){13,19}\b/g;

const cryptoRegex = {
  bitcoin: /\b[13][a-km-zA-HJ-NP-Z1-9]{25,34}\b/g, // Bitcoin (P2PKH, P2SH, Bech32)
  ethereum: /\b0x[a-fA-F0-9]{40}\b/g, // Ethereum
  litecoin: /\b[L3][a-km-zA-HJ-NP-Z1-9]{26,33}\b/g, // Litecoin
  // Додайте більше регулярних виразів для інших криптовалют
};

module.exports = {
  cardRegex,
  cryptoRegex,
};
