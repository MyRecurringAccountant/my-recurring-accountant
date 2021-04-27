INSERT INTO Expense
  (`name`,            `period`, `amount`)
VALUES
  ('TIME Magazine',   30,       5.00),
  ('Rent',            14,       417.40),
  ('Car insurance',   30,       120.83),
  ('Internet/Cable',  30,       115.75),
  ('Food',            1,        12.00),
  ('Antivirus',       365,      49.99);

UPDATE Expense
  SET `comment` = 'Example'
  WHERE TRUE;

INSERT INTO Income
  (`name`,              `period`, `amount`)
VALUES
  ('ACME Co. Payroll',  14,       1258.30),
  ('eBay Listings',     30,       55.00);

UPDATE Income
  SET `comment` = 'Example'
  WHERE TRUE;
