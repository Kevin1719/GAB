<?php
/**
 * Class Gab
 * Petit algorithme permettant s'imiter le comportement des GAB
 */
    class Gab{
        /**
         * @var float Le numéro de carte bancaire de l'utilisateur
         */
        public float $numCard;
        /**
         * @var int Stocke le mot de passe de l'utilisateur
         */
        static private int $mdp = 0;
        /**
         * @var float Stocke le montant que l'utilisateur veut retirer
         */
        static private float $amount = 0;
        /**
         * @var string Le reçu donné après le retrait
         */
        static private string $received;
        /**
         * @var int Variable utilisée pour verifier que le numéro de carte bancaire est correct
         */
        static private int $checking = 0;
        /**
         * @var float Stocke le solde de l'utilisateur
         */
        public float $sold;

        /**
         * Fonction __constructor
         * Créer l'objet soit l'instance de la class Gab
         * @param float $sold La valeur du solde sur laquelle le retrait va s'effectuer
         */
        public function __construct($sold){
            $this->sold = $sold;
        }

        /**
         * Fonction insertCard
         * Faire entrer le numéro de carte bancaire
         * @param float $numCard Le numéro de carte bancaire sur lequel on va effectuer la vérification de nombre de caractère
         *@var int $checking La valeur à checker pour affirmer que le numéro de carte bancaire est vrai
         */
        public function insertCard($numCard){
            if(strlen($numCard)==11){
                self::$checking = 1;
            }
            else{
                self::$checking = 0;
            }
        }

        /**
         * Fonction checkingCardNumber
         * Verifier le numéro de carte bancaire
         * @return int Retourne 1 si le numéro de carte bancaire est correcte sinon 0
         */
        private function checkingCardNumber(){
            if(self::$checking == 1){
                return self::$checking;
            }
            else{
                return 0;
            }
        }

        /**
         * Fonction enterPAssword
         * Faire entrer le mot de passe du compte bancaire
         */
        public function enterPassword(){
            if(self::checkingCardNumber() == 1){
                self::$mdp = (int) readline("Veuillez entrer votre mot de passe: ");
            }
            else{
                echo "Votre numéro de carte bancaire est incorrect!\n";
                die();
            }
        }

        /**
         * Fonction checkingPassword
         * Vérifier la longueur de caractère du mot de passe
         * @var int $mdp Stocke le mot de passe de l'utilisateur
         * @var float $amount Utiliser pour checker la valeur du montant
         */
        private function checkingPassword(){
                if(strlen((string) self::$mdp)==4){
                    self::$amount=1;
                }
                else{
                    self::$mdp = (int) readline("Veuillez entrer votre mot de passe: ");
                    if(strlen((string) self::$mdp)==4){
                        self::$amount=1;
                    }
                    else{
                        self::$mdp = (int) readline("Veuillez entrer votre mot de passe: ");
                        if(strlen((string) self::$mdp)==4){
                            self::$amount=1;
                        }
                        else{
                            echo "VOTRE CARTE A ÉTÉ BLOQUÉE!\n";
                            self::$amount=0;
                        }
                    }
                }
            }

        /**
         * Fonction enterAmount
         * Faire entrer le montant que l'utilisateur veut retirer
         * @var float $amount Sert de checking et de stockage de la valeur du montant
         */
        public function enterAmount(){
            self::checkingPassword();
            if(self::$amount==1){
                self::$amount = (float) readline("Veuillez entrer le montant que vous souhaitez retirer: ");
            }
            else{
                echo "VEUILLEZ VOUS RENDRE DANS UNE AGENCE!\nMERCI.\n";
                die();
            }
        }

         /**
         * Fonction checkingAmount
         * Verifier la valeur du montant entré qui doit respecter certaine condition
         * @var float $amount Sert de checking et de stockage de la valeur du montant
         * @var float $sold Sert de comparaison avec la valeur du montatntù
         * @var string $received Stocke si la personne veut avoir un reçu
         */
        private function checkingAmount(){
            while(self::$amount>$this->sold){
                echo "Votre solde est de $this->sold Ar.\n";
                self::$amount = (float) readline("Veuillez entrer le montant que vous souhaitez retirer: ");
                echo "Vous ne pouvez pas effectuer ce retrait!\n";
            }
            if(self::$amount<=$this->sold){
                while(strlen((string)self::$amount)<4){
                    self::$amount = (float) readline("Veuillez entrer le montant que vous souhaitez retirer: ");
                }
                if(strlen((string)self::$amount)>=4){
                    while(self::$amount<5000){
                        echo "Veuillez entrer un montant super à 5 000Ar\n";
                        self::$amount = (float) readline("Veuillez entrer le montant que vous souhaitez retirer: ");
                    }
                    if(self::$amount>=5000){
                        while(self::$amount%5000!=0){
                            echo "Veuillez entrer un montant divisible par 5 000Ar\n";
                            self::$amount = (float) readline("Veuillez entrer le montant que vous souhaitez retirer: ");
                        }
                        if(self::$amount%5000==0){
                            echo "Voulez-vous recevoir un reçu?\n";
                            self::$received = readline("Si 'oui': taper 'O' Si 'non': taper 'N': ");
                            self::$received = strtoupper(self::$received);
                        }
                    }
                }
            }
        }

         /**
         * Fonction checkingReceived
         * Verifier la réponse de l'utilisateur et donner le reçu ou pas
         * @var float $received Contient la réponse de l'utilisateur s'il veut un reçu ou pas
         */
        private function checkingReceive(){
            self::checkingAmount();
            $Date = date('m-d-Y h:i:s a');
            $time = time();
            if(self::$received == strtoupper('o')){
                echo $Date."\n".'Retrait effectué: '.self::$amount. "Ar.\nSolde restant: ".($this->sold-self::$amount)."Ar.\n";
            }
            elseif(self::$received == strtoupper("n")){
                echo 'Vous avez effectuez un retrait de '.self::$amount. "Ar.\nA bientôt!\n";
            }
        }

         /**
         * Fonction givingReceived
         * Donner le reçu ou pas
         */
        public function givingReceived(){
            self::checkingReceive();
        }
    }

/**
 * Programme principal
 */
echo "Bienvenu à la Société Générale\n";
echo "/////////////////////////////////////////////////////////////////////\n";
$solde = (int) readline("Veuillez entrer votre solde: ");
$numCard = (int) readline("Veuillez saisir vore numéro de carte bancaire: ");
$gab = new Gab($solde);
echo $gab->insertCard($numCard);
$gab->enterPassword();
$gab->enterAmount();
echo"////////////////////////////////////////////////////////////////////////";
$gab->givingReceived();
echo "///////////////////////////////////////////////////////////////////////";

