CREATE TABLE IF NOT EXISTS Expense (
  `id`            INTEGER UNSIGNED    NOT NULL    PRIMARY KEY AUTO_INCREMENT,
  `name`          VARCHAR(255)        NOT NULL,
  `period`        SMALLINT UNSIGNED   NOT NULL,
  `amount`        DECIMAL(8,2)        NOT NULL,
  `comment`       VARCHAR(255)                    DEFAULT NULL,
  `date_added`    DATETIME            NOT NULL    DEFAULT NOW(),
  `date_modified` DATETIME            NOT NULL    DEFAULT NOW(),
  UNIQUE (`name`),
  CHECK (`amount` >= 0),
  CHECK (`period` > 0)
) ENGINE=InnoDB;

CREATE TRIGGER IF NOT EXISTS Expense_trigger_date_modified BEFORE INSERT ON Expense
  FOR EACH ROW SET NEW.`date_modified` = NOW();

CREATE TABLE IF NOT EXISTS Income (
  `id`            INTEGER UNSIGNED    NOT NULL    PRIMARY KEY AUTO_INCREMENT,
  `name`          VARCHAR(255)        NOT NULL,
  `period`        SMALLINT UNSIGNED   NOT NULL,
  `amount`        DECIMAL(8,2)        NOT NULL,
  `comment`       VARCHAR(255)                    DEFAULT NULL,
  `date_added`    DATETIME            NOT NULL    DEFAULT NOW(),
  `date_modified` DATETIME            NOT NULL    DEFAULT NOW(),
  UNIQUE (`name`),
  CHECK (`amount` >= 0),
  CHECK (`period` > 0)
) ENGINE=InnoDB;

CREATE TRIGGER IF NOT EXISTS Income_trigger_date_modified BEFORE INSERT ON Income
  FOR EACH ROW SET NEW.`date_modified` = NOW();
