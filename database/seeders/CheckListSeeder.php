<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChecklistSeeder extends Seeder
{
    public function run()
    {

        $checklists = [
            'Espaces Confinés' => [
                'La vérification «Feu Vert Sécurité» a-t-elle été réalisée ?',
                'Appliquer la check-list «Travaux sur systèmes dé-énergisés» pour chaque énergie et répondre: tous les points applicables sont-ils conformes ?',
                'Une vérification d’atmosphère a-t-elle été réalisée avant l’entrée dans l’espace confiné ?',
                'L’atmosphère est-elle surveillée (ou régulièrement testée) pendant toute la présence en espace confiné ?',
                'La surveillance à l’entrée est-elle déterminée et assurée en tout temps ?',
                'Le nombre de personnes présentes dans l’espace confiné est-il suivi à tout moment du travail dans l’espace confiné ?',
                'La communication entre le personnel de surveillance de l’entrée et les entrants est-elle en place et régulièrement testée ?',
                'L’espace confiné est-il ventilé ?',
                'Si requise par le permis de travail, une protection respiratoire adaptée est-elle utilisée ?',
                'Le plan de sauvetage est-il connu et prêt à être activé ?',
            ],
            'Pompage d’Hydrocarbures' => [
                'La vérification «Feu Vert Sécurité» a-t-elle été réalisée ?',
                'La liste des contrôles avant démarrage a-t-elle été réalisée par l’équipe intervenante ?',
                'L’opérateur et le chef de bord ont-ils un certificat de formation / compétence pour leur fonction ?',
                'Le chantier est-il implanté en fonction de la direction du vent et le camion et les évents sont-ils bien situés hors de tout bâtiment ?',
                'Les caractéristiques et risques du produit à pomper sont-elles connues par l’équipe (inflammable, toxique...), et sa compatibilité avec les équipements utilisés a-t-elle été vérifiée ?',
                'S’il n’est pas possible de capter les rejets gazeux, ceux-ci sont-ils canalisés vers une zone sécurisée (à 15 m minimum du camion sous le vent ; sinon et uniquement pour les gaz plus légers que l’air, au-dessus du camion, à 5 m minimum du sol) ?',
                'Le camion, la zone de pompage et la zone de rejet de l’évent sont-ils balisés et, pour la zone de rejet de l’évent, signalée ? (en station-service : balisage autour de l’emprise du chantier)',
                'Les mises à la terre et la liaison équipotentielle sont-elles en place ?',
                'Un suivi en continu de l’atmosphère est-il en place au niveau de la zone de pompage, du camion et de l’évent ?',
                'Le chef de bord est-il à proximité de l’arrêt d’urgence de la pompe ?',
            ],
            'Opérations de Levage' => [
                'La vérification «Feu Vert Sécurité» a-t-elle été réalisée ?',
                'Un dossier de levage approuvé est-il disponible ?',
                'La liste des contrôles avant démarrage a-t-elle été réalisée par l’équipe intervenante au début du chantier ?',
                'Un signaleur/chef de manœuvre est-il désigné et identifiable ?',
                'L’opérateur de l’appareil de levage possède-t-il un certificat de formation / un document d’autorisation pour opérer l’appareil de levage ?',
                'Une zone interdite d’accès est-elle physiquement établie et aucune personne n’est située sous ou à proximité de la charge suspendue ?',
                'L’opération de levage est-elle exécutée conformément au dessin de levage / procédure pas à pas ? (ex: élingues, zone de départ et d’arrivée, zone survolée)',
                'Est-ce qu’aucun équipement sous pression n’est présent sous ou à proximité de la charge suspendue, sauf cas spécifique prévu dans le dossier de levage ?',
                'La charge mobile est-elle contrôlée pendant le levage ?',
            ],
            'Travaux d’Excavation' => [
                'La vérification «Feu Vert Sécurité» a-t-elle été réalisée ?',
                'Les éventuels réseaux enterrés identifiés sont-ils repérés physiquement sur site ?',
                'Une distance de sécurité est-elle respectée vis-à-vis des lignes électriques aériennes et des réseaux enterrés (>1 m si excavation par des méthodes «agressives») ?',
                'Les engins d’excavation sont-ils positionnés de façon stable et personne ne se trouve dans leur zone d’évolution ?',
                'Si nécessaire, des protections contre les éboulements sont-elles installées avant l’entrée du personnel ?',
                'La zone de fouille est-elle balisée (barrière physique rigide adaptée si risque de chute de personne ou d’engin) ?',
                'Une distance de sécurité d’1 m minimum au bord de la fouille est-elle exempte de tous matériaux extraits, engins ou équipements divers ?',
                'Avant l’entrée du personnel, des moyens d’accès sécurisés (rampes, escaliers, échelles) sont-ils installés dans la fouille ?',
                'Une inspection de la fouille a-t-elle été réalisée avant l’accès du personnel ?',
                'En présence potentielle d’atmosphère dangereuse, une vérification d’atmosphère a-t-elle été réalisée avant travaux ou entrée dans la fouille ?',
                'Si espace confiné, check-list «Espaces confinés» appliquée ?',
                'Si travaux en hauteur (dénivelé >1,3 m), check-list «Travaux en hauteur» appliquée ?',
                'Si du personnel est présent dans la fouille (>1,3 m) ou si le conducteur d’engin n’a pas une visibilité correcte ou à l’approche d’un réseau existant, un surveillant est-il présent ?',
            ],
            'Travaux à Chaud' => [
                'La vérification «Feu Vert Sécurité» a-t-elle été réalisée ?',
                'Le permis de travail à chaud est-il validé ?',
                'Appliquer la check-list « Travaux sur systèmes dé-énergisés » pour chaque énergie et répondre : tous les points applicables sont-ils conformes ? ',
                'Le personnel qui exécute l’activité porte-t-il les EPI spécifiques à la tâche ?',
                'Si la zone est à atmosphère potentiellement explosive,un contrôle de l’atmosphère a-t-il été effectué avant de démarrer le travail à chaud ?',
                'Si la zone est à atmosphère potentiellement explosive, un suivi en continu de l’atmosphère ou des contrôles à fréquence définie sont-ils réalisés et les résultats sont-ils surveillés ? ',
                'Les égouts, les ouvertures et les évents sont-ils protégés ?',
                'Toutes les matières combustibles ont-elles été enlevées, recouvertes ou maintenues humides dans la zone de travail à chaud ?',
                'Quand requises par le permis de travail, des bâches de protection contre les étincelles sont-elles en place ?',
                'Les équipements de lutte contre l’incendie ont-ils été inspectés, sont-ils disponibles sur la zone de travail et prêts à être utilisés ?',
                'Quand requise par le permis de travail, la surveillance incendie est-elle en place ?',
            ],
            'Nettoyage au Jet d’Eau Haute Pression' => [
                'La vérification «Feu Vert Sécurité» a-t-elle été réalisée ?',
                'L’opérateur possède-t-il une formation/certification pour l’utilisation du jet haute pression ?',
                'Les équipements (pompe, tuyaux, buses) sont-ils en bon état et vérifiés avant utilisation ?',
                'La zone de travail est-elle balisée et interdite d’accès aux personnes non autorisées ?',
                'Les EPI adaptés (combinaison, casque avec visière, gants, bottes) sont-ils portés par l’opérateur ?',
                'Un dispositif d’arrêt d’urgence est-il facilement accessible ?',
                'La pression et le débit du jet sont-ils adaptés à la tâche et aux matériaux ?',
                'Les risques de projection (débris, eau) sont-ils maîtrisés (écrans, barrières) ?',
                'Si travaux en espace confiné, la check-list «Espaces confinés» a-t-elle été appliquée ?',
                'Une communication claire est-elle établie entre l’opérateur et le surveillant (si applicable) ?',
            ],
        ];


        foreach ($checklists as $category => $questions) {
            foreach ($questions as $question) {
                DB::table('checklists')->insert([
                    'category' => $category,
                    'question' => $question,
                    'score' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
