<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed = [
            [
                'title' => 'The First Thing I Always Do When I Return Home from Vacation',
                'text' => 'One of the worst parts of coming home from vacation, though, is unpacking. No longer the promise of fun adventures, your vacation clothes are a worn and wrinkled tangle of not-fresh garments that drive home the fact that you are back in the real world now. Know what’s even more unpleasant than having a few suitcases worth of laundry to do? Luggage stuffed with this big to-do that’s sitting in your bedroom for a week (or more). <br> <br>
                  By riding that get-home momentum to get one last thing done, or started, in this case, you get the ball rolling on what could otherwise end up being a procrastinated task. Getting that first load of laundry in the washer is the catalyst to unpacking everything. You’ve probably unloaded all the clothes and the next load is ready to go in a pile on the floor. Since there are only a few other things left in your suitcase to put away, you might as well do those, too.   ',
                'image_id' => 2,
                'user_id' => 1,
                'created_at' => now()
            ],
            [
                'title' => 'This Is the Most Requested Wedding Gift in 2022',
                'text' => '“The wedding boom is here and demand is at its highest peak in decades. Many couples are brimming with excitement to finally celebrate with loved ones and are in the full swing of wedding planning and creating their registries,” said Lauren Kay, Executive Editor of The Knot. “With this year’s The Knot Registry Awards, couples have the ultimate guide of tested and approved essentials to inspire a registry tailored to their needs and lifestyle.” <br> <br>
                Experiences and virtual gifts—such as gift cards and cash funds—top the list of popular registry picks and continue to grow in popularity. Gift cards for Airbnb and Delta Airlines, plus honeymoon and house cash funds are favored among couples who are seeking out adventure for their post-wedding vacation, while cash funds are a great option for those who may be saving up for a home renovation or starting a family. The Knot Registry Store is the first digital wedding registry to offer sports tickets across all major sports categories, and NBA and MLB tickets became top picks on the site this year.',
                'image_id' => 3,
                'user_id' => 1,
                'created_at' => now()
            ],
            [
                'title' => 'Get Your Kids Ready for the First Day of School By Cleaning Their School Bags and Lunch Boxes',
                'text' => '“Remember the last day of school, way back in May or June? Full of the promise of long, lazy days stretching into nights spent swimming at the neighborhood pool or enjoying movies together (what even is bedtime?). It’s so easy to jump headlong into the freedom and fun of less routine and the break from daily lunch-making, carpooling, and homework-checking.
                <br><br>
                One category of items, in particular, might come back to haunt you as that first day of school approaches: backpacks and lunch boxes. If you tossed them into storage after quickly emptying them out on the last day of school — and haven’t given them a thought since — you’re not alone. ',
                'image_id' => 4,
                'user_id' => 1,
                'created_at' => now()
            ],
            [
                'title' => 'These Pop Songs Will Help You Sleep, According to Research',
                'text' => 'Looking at the 500 most streamed songs of the last decade, each hit was given a sleep score between 0-100 depending on its similarity to the musical values of the perfect lullaby, according to analysis features built into Spotify.
                 <br><br>
                 In at number one is Billie Eilish’s “i love you“. With an impressive sleep score of 87.6 out of 100, the “acousticness” of the song may have played a part. Similarly, lullabies have a strong acoustic value, which correlates to how loud or quiet a song is.
                 <br><br>
                 Second place also goes to Eilish, with “when the party’s over” earning a sleep score of 82.9. Eilish famously recorded many of her top tracks in her brother’s bedroom, and her popularity is often ascribed to her intimate, headphone-friendly sound.
                 <br><br>
                 Earning the bronze medal is “Memories” by Maroon 5 (82.4). Fourth place went to Olivia Rodrigo with “favorite crime” (81.4), a fan favorite off her debut album, “Sour”. Rounding out the top five is XXXTentacion with “the remedy for a broken heart (why am I so in love)” (81.4).
                 <br><br>
                 Other song that are great contenders for helping you fall asleep with ease include “Falling” by Harry Styles, “All of Me” by John Legend, and “You Broke Me First” by Tate McRae.',
                'image_id' => 5,
                'user_id' => 1,
                'created_at' => now()
            ],
            [
                'title' => 'If You’re Going to Read One Book In July, Make It This One',
                'text' => 'Nothing ignites the travel bug like summer. But with soaring gas prices and inflation in general, it can be a little harder to adventure long distances this year. Luckily, books allow travel at a relatively low cost (or free, if you utilize your local library or swap with friends). So dive into a new land with one of July’s fabulous new releases.
                <br><br>
                One book to take note of this month is “Pina,” an incredible work of anti-colonial fiction and the English-language debut of Tahitian author Titaua Peu. A groundbreaking novel in the world of Polynesian literature, “Pina” is the winner of the 2017 Eugène Dabit Prize and the 2019 French Voices Grand Prize.
                <br><br>
                Peu introduces readers to Pina, a nine-year-old girl who lives with her family in the desolate, rural neighborhood of Tenaho, far from the tourist-friendly beaches of Tahiti. Struggling with the legacy of colonialism through the daily experiences of poverty and destitution, Pina’s family is further devastated after her alcoholic father is involved in a tragic accident. This sets off a series of events that reveals the profound trauma and secrets that have determined the paths of Pina and her siblings. Translated from French by award-winning translator Jeffrey Zuckerman, “Pina” traces the history of a family, a culture, and an island in one moving piece of work. ',
                'image_id' => 6,
                'user_id' => 1,
                'created_at' => now()
            ],
            [
                'title' => 'Your Vintage Cookbooks Could Be Worth Up to $15,000',
                'text' => 'In 1961, Child and co-authors Simone Beck and Louisette Bertholle, published “Mastering the Art of French Cooking.” Because it made French cuisine accessible, the cookbook earned Child her own cooking show, “The French Chef,” and was described as having done “more than any other event in the last half century to reshape the gourmet dining scene.” So, yeah, Child’s cookbook is a pretty big deal.
                <br><br>
                And if you, by chance, have an autographed first edition sitting in your kitchen shelf, it could earn you a big payday, too. According to Woman’s World, a rare copy could fetch up to $5,000, while selling it as a set alongside its 1970 sequel could double the price to $9,500. You can perhaps even get more if it’s in mint condition, meaning it doesn’t have sauce stains after your grandmother tried making Child’s beloved beef stew.',
                'image_id' => 7,
                'user_id' => 1,
                'created_at' => now()
            ],

        ];

        foreach ($seed as $row) {
            DB::table('posts')->insert($row);
        }
    }
}
