/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * dictionary.js
 * Grade packs for Dictionary mode. Grades 1-8 are a starter set in the
 * Texas grade bands. Grades 9-12 and past 12th use Academic Word List headwords.
 */
var dictionaryGrades = {
    "1": [
        { word: "after", pos: "preposition", meaning: "later than", keys: ["later"] , sentence: "We left after the bell rang."},
        { word: "again", pos: "adverb", meaning: "one more time", keys: ["more", "repeat"] , sentence: "Please read the line again."},
        { word: "because", pos: "conjunction", meaning: "for the reason that", keys: ["reason"] , sentence: "She stayed home because she was sick."},
        { word: "before", pos: "preposition", meaning: "earlier than", keys: ["earlier"] , sentence: "Wash your hands before you eat."},
        { word: "found", pos: "verb", meaning: "discovered", keys: ["discover", "find"] , sentence: "He found his keys under the table."},
        { word: "right", pos: "adjective", meaning: "correct", keys: ["correct"] , sentence: "That answer is right."},
        { word: "write", pos: "verb", meaning: "to put words on paper", keys: ["paper", "words"] , sentence: "Write your name at the top."},
        { word: "small", pos: "adjective", meaning: "little in size", keys: ["little"] , sentence: "The small box fits in the bag."},
        { word: "start", pos: "verb", meaning: "to begin", keys: ["begin"] , sentence: "We start class at eight."},
        { word: "together", pos: "adverb", meaning: "with each other", keys: ["each other"] , sentence: "They walked home together."}
    ],
    "2": [
        { word: "always", pos: "adverb", meaning: "every time", keys: ["every"] , sentence: "She always locks the door."},
        { word: "around", pos: "preposition", meaning: "on every side", keys: ["side"] , sentence: "The path goes around the lake."},
        { word: "first", pos: "adjective", meaning: "before all others", keys: ["before"] , sentence: "He finished first in the race."},
        { word: "many", pos: "adjective", meaning: "a large number", keys: ["number", "lot"] , sentence: "Many students stayed after class."},
        { word: "which", pos: "pronoun", meaning: "what one", keys: ["what"] , sentence: "Which book do you want?"},
        { word: "would", pos: "verb", meaning: "a polite or possible will", keys: ["will", "polite"] , sentence: "Would you like some water?"},
        { word: "green", pos: "adjective", meaning: "the color of grass", keys: ["color", "grass"] , sentence: "The leaves are green in spring."},
        { word: "sleep", pos: "verb", meaning: "to rest with eyes closed", keys: ["rest"] , sentence: "The baby will sleep after lunch."}
    ],
    "3": [
        { word: "carry", pos: "verb", meaning: "to hold and take somewhere", keys: ["hold", "take"] , sentence: "Can you carry this box for me?"},
        { word: "clean", pos: "adjective", meaning: "not dirty", keys: ["dirty"] , sentence: "The kitchen is clean."},
        { word: "done", pos: "adjective", meaning: "finished", keys: ["finish"] , sentence: "The work is done."},
        { word: "grow", pos: "verb", meaning: "to get bigger", keys: ["bigger"] , sentence: "Plants grow when they get sun."},
        { word: "light", pos: "noun", meaning: "what lets you see", keys: ["see"] , sentence: "Turn on the light so we can see."},
        { word: "never", pos: "adverb", meaning: "not at any time", keys: ["not"] , sentence: "He never misses practice."},
        { word: "only", pos: "adverb", meaning: "and no other", keys: ["no other"] , sentence: "She is the only one left."},
        { word: "show", pos: "verb", meaning: "to let someone see", keys: ["see"] , sentence: "Show me your homework."}
    ],
    "4": [
        { word: "avoid", pos: "verb", meaning: "to keep away from", keys: ["away"] , sentence: "Avoid the icy sidewalk."},
        { word: "confirm", pos: "verb", meaning: "to say something is true", keys: ["true"] , sentence: "Please confirm the time of the meeting."},
        { word: "obvious", pos: "adjective", meaning: "easy to see", keys: ["easy", "see"] , sentence: "The mistake was obvious."},
        { word: "typical", pos: "adjective", meaning: "usual", keys: ["usual"] , sentence: "A typical school day starts early."},
        { word: "example", pos: "noun", meaning: "one thing that shows the rest", keys: ["shows"] , sentence: "A dog is an example of a pet."},
        { word: "method", pos: "noun", meaning: "a way of doing something", keys: ["way"] , sentence: "This method keeps the steps in order."},
        { word: "result", pos: "noun", meaning: "what happens because of something", keys: ["happens"] , sentence: "The result of the test was good."},
        { word: "similar", pos: "adjective", meaning: "almost the same", keys: ["same"] , sentence: "These two songs sound similar."}
    ],
    "5": [
        { word: "evidence", pos: "noun", meaning: "proof", keys: ["proof"] , sentence: "The fingerprints were evidence."},
        { word: "infer", pos: "verb", meaning: "to decide from clues", keys: ["clues"] , sentence: "From the clouds, we can infer it will rain."},
        { word: "summarize", pos: "verb", meaning: "to give the short version", keys: ["short"] , sentence: "Summarize the chapter in three lines."},
        { word: "contrast", pos: "verb", meaning: "to show the difference", keys: ["difference"] , sentence: "Contrast the two endings."},
        { word: "analyze", pos: "verb", meaning: "to study the parts", keys: ["study", "parts"] , sentence: "Analyze the data before you decide."},
        { word: "conclude", pos: "verb", meaning: "to decide after thinking", keys: ["decide"] , sentence: "From the facts, we conclude he was late."},
        { word: "precise", pos: "adjective", meaning: "exact", keys: ["exact"] , sentence: "Give a precise time, not about noon."},
        { word: "relevant", pos: "adjective", meaning: "connected to the topic", keys: ["topic"] , sentence: "That fact is relevant to the question."}
    ],
    "6": [
        { word: "context", pos: "noun", meaning: "the situation around a word or event", keys: ["situation"] , sentence: "The context shows what the word means."},
        { word: "interpret", pos: "verb", meaning: "to explain the meaning", keys: ["explain", "meaning"] , sentence: "How do you interpret this line?"},
        { word: "perspective", pos: "noun", meaning: "a way of seeing something", keys: ["seeing"] , sentence: "From her perspective, the plan was fair."},
        { word: "significant", pos: "adjective", meaning: "important", keys: ["important"] , sentence: "The change was significant."},
        { word: "structure", pos: "noun", meaning: "how the parts are arranged", keys: ["arranged", "parts"] , sentence: "The structure of the essay is clear."},
        { word: "theme", pos: "noun", meaning: "the main idea of a story", keys: ["idea", "story"] , sentence: "Friendship is the theme of the story."},
        { word: "claim", pos: "noun", meaning: "a statement someone says is true", keys: ["statement"] , sentence: "His claim needs proof."},
        { word: "source", pos: "noun", meaning: "where information comes from", keys: ["information"] , sentence: "Name the source of that quote."}
    ],
    "7": [
        { word: "argument", pos: "noun", meaning: "a case made with reasons", keys: ["reasons"] , sentence: "Her argument had three reasons."},
        { word: "bias", pos: "noun", meaning: "a tilt toward one side", keys: ["tilt", "side"] , sentence: "The report showed a bias toward one side."},
        { word: "credible", pos: "adjective", meaning: "able to be believed", keys: ["believed"] , sentence: "A named witness is more credible."},
        { word: "evaluate", pos: "verb", meaning: "to judge the value", keys: ["judge"] , sentence: "Evaluate the plan before you vote."},
        { word: "hypothesis", pos: "noun", meaning: "a testable idea", keys: ["idea", "test"] , sentence: "Her hypothesis was that plants need light."},
        { word: "imply", pos: "verb", meaning: "to suggest without saying", keys: ["suggest"] , sentence: "His smile seemed to imply he agreed."},
        { word: "objective", pos: "adjective", meaning: "based on facts, not feelings", keys: ["facts"] , sentence: "An objective report sticks to the facts."},
        { word: "valid", pos: "adjective", meaning: "sound and acceptable", keys: ["sound"] , sentence: "That reason is valid."}
    ],
    "8": [
        { word: "abstract", pos: "adjective", meaning: "about ideas, not physical things", keys: ["ideas"] , sentence: "Justice is an abstract idea."},
        { word: "analogy", pos: "noun", meaning: "a comparison that explains", keys: ["comparison"] , sentence: "He used an analogy to explain the atom."},
        { word: "coherent", pos: "adjective", meaning: "clear and connected", keys: ["clear"] , sentence: "Her essay was coherent from start to end."},
        { word: "contradict", pos: "verb", meaning: "to say the opposite", keys: ["opposite"] , sentence: "These two statements contradict each other."},
        { word: "criterion", pos: "noun", meaning: "a standard for judging", keys: ["standard"] , sentence: "Accuracy is one criterion for the grade."},
        { word: "plausible", pos: "adjective", meaning: "seems reasonable", keys: ["reasonable"] , sentence: "The excuse was plausible."},
        { word: "synthesize", pos: "verb", meaning: "to combine into one", keys: ["combine"] , sentence: "Synthesize the two articles into one summary."},
        { word: "nuance", pos: "noun", meaning: "a small difference in meaning", keys: ["small", "difference"] , sentence: "The nuance changed the meaning of the line."}
    ],
    "9": [
        { word: "analyze", pos: "verb", meaning: "to study the parts", keys: ["study", "parts"] , sentence: "Analyze the data before you decide."},
        { word: "approach", pos: "noun", meaning: "a way of dealing with something", keys: ["way"] , sentence: "Her approach to the problem was simple."},
        { word: "assess", pos: "verb", meaning: "to judge", keys: ["judge"] , sentence: "Assess the damage before you repair it."},
        { word: "assume", pos: "verb", meaning: "to take as true without proof", keys: ["true"] , sentence: "Do not assume the door is locked."},
        { word: "authority", pos: "noun", meaning: "the right to decide", keys: ["right", "decide"] , sentence: "The captain has the authority to decide."},
        { word: "available", pos: "adjective", meaning: "ready to use", keys: ["ready"] , sentence: "The book is available at the library."},
        { word: "benefit", pos: "noun", meaning: "a good result", keys: ["good"] , sentence: "Exercise has a clear benefit."},
        { word: "concept", pos: "noun", meaning: "an idea", keys: ["idea"] , sentence: "Gravity is a hard concept at first."},
        { word: "context", pos: "noun", meaning: "the setting around something", keys: ["setting"] , sentence: "The context shows what the word means."},
        { word: "data", pos: "noun", meaning: "facts collected for study", keys: ["facts"] , sentence: "The data show a rise in scores."}
    ],
    "10": [
        { word: "define", pos: "verb", meaning: "to say what something means", keys: ["means"] , sentence: "Define the word in your own line."},
        { word: "derive", pos: "verb", meaning: "to get from a source", keys: ["source"] , sentence: "We derive the rule from the examples."},
        { word: "establish", pos: "verb", meaning: "to set up", keys: ["set up"] , sentence: "They will establish a new club."},
        { word: "estimate", pos: "verb", meaning: "to make a careful guess", keys: ["guess"] , sentence: "Estimate the cost before you buy it."},
        { word: "evident", pos: "adjective", meaning: "clear", keys: ["clear"] , sentence: "Her relief was evident."},
        { word: "factor", pos: "noun", meaning: "one thing that affects a result", keys: ["affects"] , sentence: "Cost was a factor in the choice."},
        { word: "function", pos: "noun", meaning: "the job something does", keys: ["job"] , sentence: "The function of the heart is to pump blood."},
        { word: "identify", pos: "verb", meaning: "to name what something is", keys: ["name"] , sentence: "Identify the bird by its call."},
        { word: "indicate", pos: "verb", meaning: "to point to", keys: ["point"] , sentence: "The arrow will indicate the exit."},
        { word: "interpret", pos: "verb", meaning: "to explain the meaning", keys: ["explain"] , sentence: "How do you interpret this line?"}
    ],
    "11": [
        { word: "method", pos: "noun", meaning: "a planned way", keys: ["way"] , sentence: "This method keeps the steps in order."},
        { word: "occur", pos: "verb", meaning: "to happen", keys: ["happen"] , sentence: "Storms occur more often in spring."},
        { word: "period", pos: "noun", meaning: "a length of time", keys: ["time"] , sentence: "The period lasted fifty minutes."},
        { word: "policy", pos: "noun", meaning: "a set rule", keys: ["rule"] , sentence: "The store policy is no returns."},
        { word: "principle", pos: "noun", meaning: "a basic rule", keys: ["rule"] , sentence: "Fairness is the principle behind the rule."},
        { word: "process", pos: "noun", meaning: "a series of steps", keys: ["steps"] , sentence: "The hiring process has three steps."},
        { word: "require", pos: "verb", meaning: "to need", keys: ["need"] , sentence: "This class will require a notebook."},
        { word: "research", pos: "noun", meaning: "careful study", keys: ["study"] , sentence: "The research took two years."},
        { word: "respond", pos: "verb", meaning: "to answer", keys: ["answer"] , sentence: "Please respond to the email today."},
        { word: "role", pos: "noun", meaning: "the part someone plays", keys: ["part"] , sentence: "Her role in the play was small."}
    ],
    "12": [
        { word: "section", pos: "noun", meaning: "one part of a whole", keys: ["part"] , sentence: "Read the last section of the chapter."},
        { word: "significant", pos: "adjective", meaning: "important", keys: ["important"] , sentence: "The change was significant."},
        { word: "similar", pos: "adjective", meaning: "almost the same", keys: ["same"] , sentence: "These two songs sound similar."},
        { word: "source", pos: "noun", meaning: "where something comes from", keys: ["from"] , sentence: "Name the source of that quote."},
        { word: "specific", pos: "adjective", meaning: "exact and particular", keys: ["exact"] , sentence: "Give a specific date."},
        { word: "structure", pos: "noun", meaning: "how parts are arranged", keys: ["arranged"] , sentence: "The structure of the essay is clear."},
        { word: "theory", pos: "noun", meaning: "an explanation backed by evidence", keys: ["explanation", "evidence"] , sentence: "The theory explains the results."},
        { word: "vary", pos: "verb", meaning: "to change", keys: ["change"] , sentence: "Prices vary from store to store."},
        { word: "achieve", pos: "verb", meaning: "to reach a goal", keys: ["goal"] , sentence: "She worked hard to achieve her goal."},
        { word: "appropriate", pos: "adjective", meaning: "right for the situation", keys: ["right"] , sentence: "A quiet voice is appropriate in the library."}
    ],
    "after": [
        { word: "acquisition", pos: "noun", meaning: "the act of getting something", keys: ["getting"] , sentence: "The acquisition of the building took a year."},
        { word: "consequence", pos: "noun", meaning: "a result", keys: ["result"] , sentence: "One consequence of the rain was a delay."},
        { word: "constitute", pos: "verb", meaning: "to make up", keys: ["make up"] , sentence: "These three chapters constitute the book."},
        { word: "distribute", pos: "verb", meaning: "to give out", keys: ["give"] , sentence: "Distribute the papers to the class."},
        { word: "economy", pos: "noun", meaning: "the system of making and using goods", keys: ["goods"] , sentence: "The economy slowed last year."},
        { word: "environment", pos: "noun", meaning: "the surroundings", keys: ["surroundings"] , sentence: "The forest is a rich environment."},
        { word: "export", pos: "verb", meaning: "to send goods out of a country", keys: ["send"] , sentence: "The country will export grain."},
        { word: "finance", pos: "noun", meaning: "the management of money", keys: ["money"] , sentence: "She studied finance in college."},
        { word: "formula", pos: "noun", meaning: "a set way of calculating", keys: ["calculating"] , sentence: "Use the formula to find the area."},
        { word: "income", pos: "noun", meaning: "money received", keys: ["money"] , sentence: "Her income rose after the new job."},
        { word: "legislate", pos: "verb", meaning: "to make laws", keys: ["laws"] , sentence: "Congress can legislate new rules."},
        { word: "percent", pos: "noun", meaning: "a part out of one hundred", keys: ["hundred"] , sentence: "Ten percent of the class was absent."}
    ]
};
