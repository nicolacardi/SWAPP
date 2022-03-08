UPDATE tab_famiglie JOIN tab_demonames ON cognomeor_demo = cognomepadre_fam SET cognomepadre_fam = cognomefake_demo;

UPDATE tab_famiglie SET emailpadre_fam = LOWER(CONCAT( nomepadre_fam , cognomepadre_fam, "@gmail.com"));

UPDATE tab_famiglie SET emailmadre_fam = LOWER(CONCAT( nomemadre_fam , cognomemadre_fam, "@gmail.com"));

UPDATE tab_anagraficaalunni SET cf_alu = CONCAT("XXXYYY", RIGHT(cf_alu,8));

UPDATE tab_famiglie SET cfpadre_fam = CONCAT("XXXYYY", RIGHT(cfpadre_fam,8));

UPDATE tab_famiglie SET cfmadre_fam = CONCAT("XXXYYY", RIGHT(cfmadre_fam,8));