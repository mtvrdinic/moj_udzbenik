#include <bits/stdc++.h>
#include <iostream> 
#include <math.h>

using namespace std;

set<int> final;
bool users[10];

std::string toBinary(long long n) {
    std::string r;
    while(n != 0) {r = (n % 2 == 0 ? "0 ": "1 ") +  r; n /= 2;}
    return r;
}

int smart(long long mask, int i, const long long (&array)[10]){
   if(mask == pow(2, 24) - 1){
    return 0;
   }
   if(i > 1) return 140000000;

   long long new_mask = mask | array[i];

   cout << "maska: " << toBinary(mask) << " nova maska: " << toBinary(new_mask) << "\n";
   cout << "maska: " << toBinary(pow(2, 24) - 1) << " nova maska: " << toBinary(pow(2,24) - 1) << "\n";

   int prvi = smart(new_mask, i + 1, array) + 1;
   int drugi = smart(mask, i + 1, array);
   cout << "prvi: " << prvi << " drugi: " << drugi << "\n"; 
   if(prvi < drugi) {
      final.insert(i + 1);
      return prvi;
   } else {
    return drugi;
   }
   //return min(smart(new_mask, i + 1, array) + 1, smart(mask, i + 1, array)); 
}


int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  long long broj_ljudi, broj_knjiga;
  long long array[10] = {};
  

  cin >> broj_ljudi;
  cin >> broj_knjiga;

  long long tmp, n;
  for(long long i = 0; i < broj_ljudi; i++){
    cin >> tmp;

    array[i] = tmp;
    //cout << toBinary(array[tmp]) << endl;
  } 

  
  /*for(long long i = 1; i < 10; i++){
    cout << toBinary(array[i]) << '\n';
  }*/
  

  
  //cout << endl;
  cout << smart(0, 0, array) << endl;
  for(auto&& i : final){
    cout << i << " ";
  }

  //cout << endl;
 //cout << endl;

  //cout << toBinary(pow(2, 22) - 1);
  return 0;
}